#!/usr/bin/perl

use Data::Dumper;
use Parallel::ForkManager;
use Config::Abstract::Ini;
use FindBin qw($Bin);
use lib "$Bin/module";
use DBI;
use Ipmodule;

# According to config file,config for system.
eval{
  my $cfg=new Config::Abstract::Ini("$Bin/config.ini");
  %Data=$cfg->get_entry('mysql');
};

while(1){
my $pm = new Parallel::ForkManager( 5 );
my $in=DBI->connect("DBI:mysql:database=".$Data{'database'}.";host=".$Data{'host'},$Data{'username'},$Data{'password'}) or die "Error: Connect DB Network\n";
my $select=$in->prepare("select * from w3a_net_monitor where task_mode=0");
$select->execute();
	while(my @list=$select->fetchrow_array()){
		#print Dumper($list['id']);
		$pm->start and next;
		monitor_do("@list");
		$pm->finish;
	}
	sleep 5;
	redo;
}
$in->disconnect();

sub monitor_do{
  local(@list)=shift;
  @lists=split(/\s+/,"@list");
  $item=check_item($lists[2],$lists[7]);
  
  if($lists[7]==1)
  {
     if($item eq "allow")
     {
	db_doing("insert into w3a_net_monitor_network_attack(network_status,time_start,ip_address,last_node,user_id)values('存活探测异常',now(),'$lists[2]','".Ipmodule::domain_ip($lists[2])."',$lists[8])");
     }else{
	db_doing("insert into w3a_net_monitor_network_attack(network_status,time_start,ip_address,last_node,user_id)values('线路异常',now(),'$lists[2]','$item',$lists[8])");
     }
  }
  elsif($lists[7]==2)
  {
     if($item==200)
     {
	db_doing("insert into w3a_net_monitor_web_attack(web_status,time_start,ip_address,offer_status,user_id)values('icmp探测失败',now(),'$lists[2]',200,$lists[8])");
     }
     elsif($item eq 'error')
     {
	db_doing("insert into w3a_net_monitor_web_attack(web_status,time_start,ip_address,offer_status,user_id)values('链接失败',now(),'$lists[2]',0,$lists[8])");
     }
     else
     {
	db_doing("insert into w3a_net_monitor_web_attack(web_status,time_start,ip_address,offer_status,user_id)values('状态异常',now(),'$lists[2]',$item,$lists[8])");

     }
  }
}

sub db_doing{

 local($sql)=shift;

 my $in=DBI->connect("DBI:mysql:database=".$Data{'database'}.";host=".$Data{'host'},$Data{'username'},$Data{'password'}) or die "Error: Connect DB Network\n";
 $select1=$in->prepare("SET NAMES UTF8");
 $select1->execute();
 my $select=$in->prepare($sql);

 $select->execute();

}

