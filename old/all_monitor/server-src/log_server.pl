##############################################################################
#
#
#	W3a_system Main program.
#
#	Seven Subroutine.
#
#	Server receive data for client,
#
#	Server receive for Data,process and save to mysql.
#
###############################################################################
#!/usr/bin/perl

use IO::Socket;
use IO::Select;
use DBI;
use Config::Abstract::Ini;


eval{
  my $cfg=new Config::Abstract::Ini("config.ini");
  %Data=$cfg->get_entry('mysql');
};

my $socket=IO::Socket::INET->new(LocalAddr =>$Data{'server_ip'},
                                                LocalPort =>$Data{'server_port'},
                                                Listen   =>5,
                                                Proto    =>'tcp') or die $@;
my $read_set=new IO::Select();
my %bufall;
$read_set->add($socket);

while(1)
{
  my ($rh_set) = IO::Select->select($read_set, undef, undef, undef);
  foreach my $rh (@$rh_set)
  {
	if($rh == $socket)
	{
	  my $ns = $rh->accept();
	  $read_set->add($ns);
	}else{
	  my $buf = undef;
	  if (sysread($rh,$buf,1024))
	  {
		$buf = $bufall{$rh}.$buf;  # Fill data to bufall.
		my $pos=rindex($buf,"\n");
		my $buf1=substr($buf,0,$pos);
		my $buf2=substr($buf,$pos+1);
		$bufall{$rh}=$buf2;  # Save Data to buf.
		$buf=$buf1;  # Process to buf.
		log_regex_do($buf);
	  }else{
		$read_set->remove($rh);
		$rh->close;
	  }
	}
   }
}

######################
#
#  log regex process
#
######################
sub log_regex_do{

  my $log=shift;

  # Regex for log
  @ack=split(/\|/,$log);

  # Make sure regex identification log.
  if(@ack[0]=~m#t:(.*)#)
  {
	$type=$1;
	$log_type=type_result($type);
  }
  if(@ack[2]=~m#so:(.*)#)
  {
        $source=$1;
  }
  if(@ack[3]=~m#lo:(.*)#)
  {
        $local=$1;
  }
  if(@ack[4]=~m#da:(.*)#)
  {
         $date=$1;
  }
  if(@ack[5]=~m#ti:(.*)#)
  {
        $time=$1;
  }
  if(@ack[6]=~m#opt:(.*)#)
  {
        $option=$1;
  }
  if(@ack[7]=~m#of:(.*)#)
  {
        $offer=$1;
  }
  if(@ack[8]=~m#u:(.*)#)
  {
        $user=$1;
  }
  if(defined(bool($user,$local)))
  {
    if(@ack[1]=~m#me:(.*)#)
    {
	  $method=$1;
	  $log_result=log_result($method);
	  if($log_result)
	  {
		  if(defined(get_result_db($log_type,$log_result,$method,$source,$local,result_data($date,$time),$option,$offer,$user)))
		  {
			  report_data($log_result,$user);
		  }
  	  }
    }
  }
}

######################
#
#  Update report data
#
######################
sub report_data
{
  ($log_result,$user)=@_;

  my $in=DBI->connect("DBI:mysql:database=".$Data{'database'}.";host=".$Data{'host'},$Data{'username'},$Data{'password'}) or die "Error: Connect DB log\n";

  $select=$in->prepare("set names utf8");
  $select->execute();

  $sql="select method_level from w3a_log_method where id=$log_result";
  $sth=$in->prepare( $sql );
  $sth->execute();
  $result_rule=$sth->fetchrow_array();
  $sth->finish();

  $sql2="select attack_sum from w3a_log_method where id=$log_result";
  $sth=$in->prepare( $sql2 );
  $sth->execute();
  $attack_sum=$sth->fetchrow_array();
  $sth->finish();
  $attack_sum=$attack_sum+1;

  $sql3="update w3a_log_method set attack_sum=$attack_sum where id=$log_result";
  $sth=$in->prepare( $sql3 );
  $sth->execute();
  $sth->finish();
}


######################
#
#  Inquiry user exists
#
######################
sub bool{

  my $user=shift;
  my $local=shift;
  my $in=DBI->connect("DBI:mysql:database=".$Data{'database'}.";host=".$Data{'host'},$Data{'username'},$Data{'password'}) or die "Error Connect DB log\n";

  $select=$in->prepare("set names utf8");
  $select->execute();
  $sql="select * from w3a_log_monitor where task_name='$user' and task_url='$local'";
  $sth=$in->prepare( $sql );
  $sth->execute();
  $count=$sth->fetchrow_array();
  $sth->finish();

  return $count;
}


######################
#
# Attack log insert database
#
######################
sub get_result_db
{
  ($type,$method_id,$method_url,$method_source,$method_user,$method_date,$method_option,$method_offer)=@_;

   my $in=DBI->connect("DBI:mysql:database=".$Data{'database'}.";host=".$Data{'host'},$Data{'username'},$Data{'password'}) or die "Error Connect DB log\n";

   $do_result=$in->prepare("
                        insert into w3a_log_monitor_attack (
                                                method_name,
                                                method_url,
                                                attack_source,
                                                attack_user,
                                                attack_date,
                                                attack_option,
                                                attack_offer,
                                                log_type
                                                        )values(?,?,?,?,?,?,?,?)"
                        );

  $do_result->bind_param(1,$method_id);
  $do_result->bind_param(2,$method_url,{ TYPE=> SQL_VARCHAR });
  $do_result->bind_param(3,$method_source);
  $do_result->bind_param(4,$method_user);
  $do_result->bind_param(5,$method_date);
  $do_result->bind_param(6,$method_option);
  $do_result->bind_param(7,$method_offer);
  $do_result->bind_param(8,$type);

  return $do_result->execute();
}


######################
#
#  Update rule Statistics
#
######################
sub attack_update
{
   ($id,$att_sum)=@_;

   $att_sum=$att_sum+1;

   my $in=DBI->connect("DBI:mysql:database=".$Data{'database'}.";host=".$Data{'host'},$Data{'username'},$Data{'password'}) or die "Error Connect DB log\n";
   $do_result=$in->do("update w3a_log_method set attack_sum=$att_sum where id=$id");
}

######################
#
# Match log type
#
######################
sub type_result
{

  local($method)=shift;
  my $in=DBI->connect("DBI:mysql:database=".$Data{'database'}.";host=".$Data{'host'},$Data{'username'},$Data{'password'}) or die "Error Connect DB log\n";

  $select=$in->prepare("set names utf8");
  $select->execute();
  $results=$in->selectall_hashref("select * from w3a_log_monitor_type",'id');

  foreach my $id(sort keys %$results)
  {
        if($method eq $results->{$id}->{'log_type_name'})
        {
                 $type=$results->{$id}->{'id'};
        }
  }
  return $type;
}

######################
#
# Attack rule testing
#
######################
sub log_result
{

  local($method)=shift
;
  my $target_id=undef;
  my $in=DBI->connect("DBI:mysql:database=".$Data{'database'}.";host=".$Data{'host'},$Data{'username'},$Data{'password'}) or die "Error Connect DB! attack \n";

  $select=$in->prepare("set names utf8");
  $select->execute();

  $results=$in->selectall_hashref("select * from w3a_log_method",'id');

  foreach my $id(sort keys %$results)
  {
        $switch=$results->{$id}->{'method_switch'};
        # Determine start for task
        if($switch != 0)
        {
                # Determine match for regex
                if($method=~m/$results->{$id}->{'method_regex'}/i)
                {
			 # Return rule id insert to attack table 
                         $target_id=$results->{$id}->{'id'};
			 # Update rule table attack sum
                         attack_update($target_id,$results->{$id}->{'attack_sum'});
                }
        }
  }
  return $target_id;

}

######################
#
# Log date format
#
######################
sub result_data{

        local($tmp_data)=shift;
        local($time)=shift;

        @data=split(/\//,$tmp_data);

        %mount=(
                1=>"Jan",
                2=>"Feb" ,
                3=>"Mar" ,
                4=>"Apr" ,
                5=>"May" ,
                6=>"Jun",
                7=>"Jul" ,
                8=>"Aug",
                9=>"Sep",
                10=>"Oct" ,
                11=>"Nov" ,
                12=>"Dec"
                );

        foreach $keys (sort keys %mount)
        {
                if($mount{$keys} eq $data[1])
                {
                   $data[1]=$keys;
                }
        }
        $result=$data[2].'-'.$data[1].'-'.$data[0]." ".$time;
        return $result;
}

