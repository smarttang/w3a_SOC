package Ipmodule;

use Net::Ping;
use LWP::UserAgent;
use MIME::Lite;
use Net::Traceroute::PurePerl;
use HTTP::Status qw(:constants :is status_message);

require Exporter;

@ISA=(Exporter);

@EXPORT=qw( domain_icmp domain_ip web_service check_item Send_html_email tracert);

##-------------------Email Send to User Service(1/string)-----------------
sub Ipmodule::Send_html_email{

   local($to)=shift;
   local($cc)=shift;
   local($subject)=shift;
   local($text)=shift;

   eval {

        $msg = MIME::Lite->new(
          From     =>'tangyucong@',
          To       => $to,
          Cc       => $cc,
          Subject  => $subject,
          Type     => 'text/html',
          Data     => $text,
        );

        $msg->attr('content-type.charset' => 'UTF-8');

        $msg->send('smtp','maxxxx.com.cn', Timeout=>60,AuthUser=>'tangyucong@xxx,com', AuthPass=>'');

   } or return 2;
}
#Send_html_email('user@mail.com','cc@mail.com','主题','内容');

##-------------------check domain for icmp (:true/false)------------------
sub Ipmodule::domain_icmp{
	
         $bool='true';
	 
         local($tmp_url)=shift;

	 if($tmp_url =~m/^(http|https|ftp)\:\/\/(.*)/){
	   if($2 =~m/(.*)\/$/){
	         $url=$1;
	   }else{
		 $url=$2;
	   }
	 }else{
		$url=$tmp_url;
	 }
	 
         $p=Net::Ping->new("icmp");
	 
         $bool='false' unless $p->ping(Ipmodule::domain_ip($url),2);
	 
         $p->close();
	 
         return $bool;
}

##-----------------return domain vesting for ip---------------------------
sub Ipmodule::domain_ip{
	
         local($host)=shift;
	 
         $p=Net::Ping->new();
	 
         $p->hires();

         if($host =~m/^(http|https|ftp)\:\/\/(.*)/){
           if($2 =~m/(.*)\/$/){
                 $url=$1;
           }else{
                 $url=$2;
           }
         }else{
                $url=$host;
         }

       	 ($ret,undef,$ip) = $p->ping($url, 1);

         $p->close();
	 
         return $ip;
}

##-----------------return WebService status(true/false)------------------
sub Ipmodule::web_service{
	local($url)=shift;

	my $ua = LWP::UserAgent->new;

	$ua->timeout(4);

	my $req = HTTP::Request->new(GET => $url);

	my $res = $ua->request($req);

	if($res->is_success)
	{
	   return "true";
	}
	elsif($res->is_error)
	{
	   return "404";
	}
	elsif($res->is_redirect)
	{
	   return "302";
	}
}

##-----------------return option number----------------------------------
sub Ipmodule::check_item{

	local($url)=shift; # service one

	local($service)=shift; # service two

	# host or network checking.
	if($service==1)
	{
	   # icmp checking and tracert route for url/ip-address.
	   # icmp checking if error,check tracert route.
	   if(Ipmodule::domain_icmp($url) eq "true")
	   {
		return "true";
	   }
	   else
	   {
		# try to tracert.
		if(Ipmodule::tracert($url) eq "true")
		{
			return "allow";
		}
		else
		{
			return Ipmodule::tracert($url);
		}
	   }
	}
	elsif($service==2)  # website checking
	{
	    $web_check=Ipmodule::web_service($url);
	    $icmp_check=Ipmodule::domain_icmp($url);
	    # icmp checking,testing get data  from website;
	    # According to result if checking error,return message..
	    if($web_check eq "true" && $icmp_check eq "true")
	    {
		return "true";
	    }
  	    elsif($web_check eq "true" && $icmp_check eq "false")
	    {
		return "200";
	    }
	    elsif($web_check ne "true" && $icmp_check eq "true")
	    {
		return $web_check;
	    }else{
		return "error";
	    }
	}
}

##--------------Find USEREmail for the item---------------------------
sub Ipmodule::find_email{
	
	local($task_id)=shift;

        $in=DBI->connect("DBI:mysql:database=w3a_monitor;host=localhost","root","") or die "No:$!\n";

        my $select=$in->prepare("select email from web_account where id=$task_id");

        $select->execute();

        @list=$select->fetchrow_array();
  
        return "@list";
}

##-------------Tracert Mode for the item------------------------------
sub Ipmodule::tracert{

	local($tmp)=shift;

	if($tmp=~m#^(http:|ftp:|https:)\/\/(.*)\/#){
		$result=$1;
	}else{
		$result=$tmp;
	}

	my $tr = new Net::Traceroute::PurePerl(
	     host           => $result,
	     debug          => 0,
	     query_timeout  => 1,
	     packetlen      => 40,
	     concurrent_hops	=> 2,
	     protocol       => 'icmp', # Or icmp
	);

	$tr->traceroute;

	if($tr->found){
	    my $hops = $tr->hops;
	    if($hops > 1) {
		for($i=0;$i<=$hops;$i++){
			$result=$tr->hop_query_host($tr->hops-$i, 0);
			if($result ne ""){
				push(@results,$result);
			}
		}
	    }
	}
	$task_ip=shift(@results);
	if($task_ip eq $results[-1]){
		return "true";
	}else{
		return $results[-1];
	}
}
1;

