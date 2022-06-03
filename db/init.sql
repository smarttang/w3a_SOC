CREATE DATABASE w3a_soc;
USE w3a_soc;
/*
 Navicat MySQL Data Transfer

 Source Server Type    : MariaDB
 Source Server Version : 50568
 Source Schema         : w3a_soc

 Target Server Type    : MariaDB
 Target Server Version : 50568
 File Encoding         : 65001

 Date: 13/05/2022 02:38:41
*/

-- ----------------------------
-- Table structure for w3_alter_channel
-- ----------------------------
DROP TABLE IF EXISTS `w3_alter_channel`;
CREATE TABLE `w3_alter_channel` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `alter_id` bigint(20) NOT NULL COMMENT 'id',
  `alter_source_id` bigint(20) NOT NULL COMMENT '告警渠道id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='告警渠道表';

-- ----------------------------
-- Table structure for w3_alter_config
-- ----------------------------
DROP TABLE IF EXISTS `w3_alter_config`;
CREATE TABLE `w3_alter_config` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `alter_source_createtime` datetime NOT NULL COMMENT '创建时间',
  `alter_source_name` varchar(50) NOT NULL COMMENT '告警源名称',
  `alter_source_updatetime` datetime DEFAULT NULL COMMENT '更新时间',
  `alter_source_type` tinyint(1) DEFAULT '0' COMMENT '告警源，0：企业微信、1：钉钉、2：邮件',
  `alter_config_status` tinyint(1) DEFAULT '0' COMMENT '配置状态，0：启用、1：不启用',
  `alter_config_email_username` varchar(255) DEFAULT '' COMMENT '邮箱账号',
  `alter_config_email_password` varchar(255) DEFAULT '' COMMENT '邮箱密码',
  `alter_config_token` varchar(255) DEFAULT '' COMMENT '企业微信、钉钉的TOKEN',
  `alter_config_delete` tinyint(1) DEFAULT '1' COMMENT '逻辑删除,0：已删除，1：启用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='告警配置表';

-- ----------------------------
-- Table structure for w3_alter_logs
-- ----------------------------
DROP TABLE IF EXISTS `w3_alter_logs`;
CREATE TABLE `w3_alter_logs` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `alter_id` bigint(20) NOT NULL COMMENT '规则id',
  `alter_createtime` datetime NOT NULL COMMENT '创建时间',
  `alter_info` longtext NOT NULL COMMENT '告警内容',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='告警记录表';

-- ----------------------------
-- Table structure for w3_alter_master
-- ----------------------------
DROP TABLE IF EXISTS `w3_alter_master`;
CREATE TABLE `w3_alter_master` (
  `alter_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `alter_name` text NOT NULL COMMENT '告警内容',
  `alter_scenes` tinyint(1) DEFAULT '1' COMMENT '场景：1:攻击流量场景观测，2:统计报表场景',
  `alter_trigger` bigint(20) DEFAULT '0' COMMENT '告警触发',
  `alter_createtime` datetime NOT NULL COMMENT '创建时间',
  `alter_updatetime` datetime DEFAULT NULL COMMENT '更新时间',
  `alter_status` tinyint(1) DEFAULT '1' COMMENT '告警状态,0：关闭，1：开启',
  `alter_delete` tinyint(1) DEFAULT '1' COMMENT '告警状态,0：删除，1：启用',
  PRIMARY KEY (`alter_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='告警主表';

-- ----------------------------
-- Table structure for w3_alter_paramets
-- ----------------------------
DROP TABLE IF EXISTS `w3_alter_paramets`;
CREATE TABLE `w3_alter_paramets` (
  `alter_id` bigint(20) NOT NULL COMMENT 'id',
  `alter_url` text COMMENT '配置URL内容',
  `alter_useragent` text COMMENT '配置USERAGENT',
  `alter_ipaddr` text COMMENT '配置IP地址',
  `alter_referer` text COMMENT '配置Referer',
  `alter_frequency` bigint(20) DEFAULT '0' COMMENT '访问频率',
  `alter_statistics_type` tinyint(1) DEFAULT '0' COMMENT '统计类型,0:巡检统计数据,1:报表处理数据',
  `alter_time` tinyint(1) DEFAULT '1' COMMENT '时间类型,1：每分钟，2：每小时',
  PRIMARY KEY (`alter_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='告警参数表';

-- ----------------------------
-- Table structure for w3_apps_website
-- ----------------------------
DROP TABLE IF EXISTS `w3_apps_website`;
CREATE TABLE `w3_apps_website` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `apps_type` tinyint(1) NOT NULL COMMENT '关联的类型,0:关联Git,1:关联容器服务,2:关联云资产',
  `apps_string_info` varchar(255) DEFAULT NULL COMMENT '资产内容,字符串型',
  `apps_number_info` bigint(20) DEFAULT NULL COMMENT '资产内容,数字型',
  `apps_website_id` bigint(20) NOT NULL COMMENT '关联站点的ID',
  `apps_updatetime` datetime DEFAULT NULL COMMENT '更新时间',
  `apps_createtime` datetime NOT NULL COMMENT '创建时间',
  `apps_status` tinyint(1) DEFAULT '1' COMMENT '关联状态,0:取消,1:启用',
  `apps_errormsg` varchar(255) DEFAULT NULL COMMENT '异常原因',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='应用和站点关联配置表';

-- ----------------------------
-- Table structure for w3_clouds_assets
-- ----------------------------
DROP TABLE IF EXISTS `w3_clouds_assets`;
CREATE TABLE `w3_clouds_assets` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `cloud_assets_id` varchar(32) DEFAULT NULL COMMENT '云资产实例ID',
  `cloud_assets_zone` varchar(30) DEFAULT NULL COMMENT '云资产归属可用区',
  `cloud_assets_regions` varchar(30) DEFAULT NULL COMMENT '云资产归属地区',
  `cloud_assets_config` varchar(68) DEFAULT NULL COMMENT '云资产配置',
  `cloud_assets_intranet_ip` varchar(20) DEFAULT NULL COMMENT '云资产内网IP',
  `cloud_assets_public_ip` varchar(20) DEFAULT NULL COMMENT '云资产外网IP',
  `cloud_assets_instance_name` varchar(58) DEFAULT NULL COMMENT '云资产实例别名',
  `cloud_assets_fingerprint` varchar(255) DEFAULT NULL COMMENT '云资产指纹,如系统版本',
  `cloud_assets_createtime` datetime DEFAULT NULL COMMENT '云资产创建时间',
  `cloud_assets_expiredtime` datetime DEFAULT NULL COMMENT '云资产释放时间',
  `cloud_assets_updatetime` datetime DEFAULT NULL COMMENT '云资产更新时间',
  `cloud_assets_securitygroup_id` varchar(255) DEFAULT NULL COMMENT '云资产安全组ID',
  `cloud_assets_status` tinyint(1) DEFAULT '1' COMMENT '云资产原生状态,0:停用,1:运行中',
  `cloud_assets_security_status` tinyint(1) DEFAULT '0' COMMENT '云资产安全状态,0:待检查,1:相对安全,2:不安全',
  `cloud_assets_types` tinyint(1) DEFAULT '0' COMMENT '云资产类型,0:云主机,1:域名,2:redis,3:mysql,4:MariaDB,5:SQLServer,6:MongoDB',
  `cloud_assets_ports` varchar(6) DEFAULT '1' COMMENT '云资产端口号',
  `cloud_assets_simple_name` varchar(255) DEFAULT '1' COMMENT '云资产通用字段',
  `cloud_assets_delete` tinyint(1) DEFAULT '1' COMMENT '云资产删除,0:删除,1:正常',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='云资产数据';

-- ----------------------------
-- Table structure for w3_clouds_secrets
-- ----------------------------
DROP TABLE IF EXISTS `w3_clouds_secrets`;
CREATE TABLE `w3_clouds_secrets` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `cloud_secret_type` tinyint(1) NOT NULL COMMENT '云厂商类型,0:阿里云,1:腾讯云,2:华为云',
  `cloud_access_key` varchar(255) NOT NULL COMMENT 'AccessKeyId',
  `cloud_access_token` varchar(255) NOT NULL COMMENT 'AccessSecret',
  `cloud_secret_status` tinyint(1) DEFAULT '1' COMMENT '状态,0:停用,1:启用',
  `cloud_secret_delete` tinyint(1) DEFAULT '1' COMMENT '删除状态,0:删除,1:启用',
  `cloud_secret_create_userid` bigint(20) NOT NULL COMMENT '创建的用户ID',
  `cloud_secret_updatetime` datetime DEFAULT NULL COMMENT '更新时间',
  `cloud_secret_createtime` datetime NOT NULL COMMENT '创建时间',
  `cloud_secret_errormsg` varchar(255) DEFAULT NULL COMMENT '异常原因',
  `cloud_secret_info` varchar(20) NOT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='云厂商配置';

-- ----------------------------
-- Table structure for w3_git_api_analyze
-- ----------------------------
DROP TABLE IF EXISTS `w3_git_api_analyze`;
CREATE TABLE `w3_git_api_analyze` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `git_store_service_id` bigint(20) NOT NULL COMMENT '资产的ID',
  `git_store_service_commitid` char(50) NOT NULL COMMENT 'git的commitID',
  `git_store_commit_createtime` datetime NOT NULL COMMENT '入库时间',
  `git_store_commit_apibase` char(32) NOT NULL COMMENT '主目录',
  `git_store_commit_apichild` char(32) DEFAULT NULL COMMENT '子目录',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='git的接口分析';

-- ----------------------------
-- Table structure for w3_git_commits
-- ----------------------------
DROP TABLE IF EXISTS `w3_git_commits`;
CREATE TABLE `w3_git_commits` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `git_store_service_id` bigint(20) NOT NULL COMMENT '资产的ID',
  `git_store_service_commitid` char(50) NOT NULL COMMENT 'git的commitID',
  `git_store_commit_createtime` datetime NOT NULL COMMENT '入库时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='git的commit记录';

-- ----------------------------
-- Table structure for w3_git_component_analyze
-- ----------------------------
DROP TABLE IF EXISTS `w3_git_component_analyze`;
CREATE TABLE `w3_git_component_analyze` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `git_store_service_id` bigint(20) NOT NULL COMMENT '资产的ID',
  `git_store_service_commitid` char(50) NOT NULL COMMENT 'git的commitID',
  `git_store_commit_createtime` datetime NOT NULL COMMENT '入库时间',
  `git_store_commit_component_path` char(32) DEFAULT NULL COMMENT '存储路径',
  `git_store_commit_component_packname` char(32) DEFAULT NULL COMMENT '模块名',
  `git_store_commit_component_version` char(32) DEFAULT NULL COMMENT '版本号',
  `git_store_commit_component_count` bigint(20) DEFAULT NULL COMMENT '统计数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='git的组件调用分析';

-- ----------------------------
-- Table structure for w3_git_lang_counts
-- ----------------------------
DROP TABLE IF EXISTS `w3_git_lang_counts`;
CREATE TABLE `w3_git_lang_counts` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `git_store_service_id` bigint(20) NOT NULL COMMENT '资产的ID',
  `git_store_service_commitid` char(50) NOT NULL COMMENT 'git的commitID',
  `git_store_commit_createtime` datetime NOT NULL COMMENT '入库时间',
  `git_store_commit_lang_name` char(32) NOT NULL COMMENT '语言名称',
  `git_store_commit_lang_code_count` bigint(20) NOT NULL COMMENT '代码行数',
  `git_store_commit_lang_file_count` bigint(20) NOT NULL COMMENT '文件数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='git的组成分析';

-- ----------------------------
-- Table structure for w3_gitstore_assets
-- ----------------------------
DROP TABLE IF EXISTS `w3_gitstore_assets`;
CREATE TABLE `w3_gitstore_assets` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `git_store_service_name` varchar(255) NOT NULL COMMENT '服务名称',
  `git_store_service_type` tinyint(1) NOT NULL COMMENT 'git的类型,0:Gitee,1:GitHub,2:GitLab',
  `git_store_service_addr` varchar(255) NOT NULL COMMENT 'git仓库主地址',
  `git_store_service_status` tinyint(1) DEFAULT '1' COMMENT '状态,0:不可用,1:可用',
  `git_store_service_language` varchar(32) DEFAULT '待检测' COMMENT '语言类型，工具自动检测',
  `git_store_serivce_delete_status` tinyint(1) DEFAULT '1' COMMENT '删除状态,0:删除,1:启用',
  `git_store_serivce_control` tinyint(1) DEFAULT '0' COMMENT '是否是手动创建,0:自动,1:手动',
  `git_store_serivce_updatetime` datetime DEFAULT NULL COMMENT '更新时间',
  `git_store_service_createtime` datetime NOT NULL COMMENT '创建时间',
  `git_store_service_config_id` bigint(20) DEFAULT '0' COMMENT '归属的配置ID',
  `git_store_service_errormsg` varchar(255) DEFAULT NULL COMMENT '异常原因',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='git仓库资产';

-- ----------------------------
-- Table structure for w3_gitstore_config
-- ----------------------------
DROP TABLE IF EXISTS `w3_gitstore_config`;
CREATE TABLE `w3_gitstore_config` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `git_store_type` tinyint(1) NOT NULL COMMENT 'git的类型,0:Gitee,1:GitHub,2:GitLab',
  `git_store_addr` varchar(255) NOT NULL COMMENT 'gitlab/GITHUB主地址',
  `git_store_username` varchar(255) NOT NULL COMMENT '账号',
  `git_store_password` varchar(255) NOT NULL COMMENT '密码',
  `git_store_status` tinyint(1) DEFAULT '1' COMMENT '状态,0:停用,1:启用',
  `git_store_delete_status` tinyint(1) DEFAULT '1' COMMENT '删除状态,0:删除,1:启用',
  `git_store_create_userid` bigint(20) NOT NULL COMMENT '创建的用户ID',
  `git_store_updatetime` datetime DEFAULT NULL COMMENT '更新时间',
  `git_store_createtime` datetime NOT NULL COMMENT '创建时间',
  `git_store_errormsg` varchar(255) DEFAULT NULL COMMENT '异常原因',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='git配置';

-- ----------------------------
-- Table structure for w3_ids_attacks
-- ----------------------------
DROP TABLE IF EXISTS `w3_ids_attacks`;
CREATE TABLE `w3_ids_attacks` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `ids_actions` varchar(255) NOT NULL COMMENT '策略动作',
  `ids_app_proto` varchar(50) NOT NULL COMMENT '请求应用协议',
  `ids_app_category` varchar(255) NOT NULL COMMENT '攻击类别',
  `ids_app_destip` varchar(32) NOT NULL COMMENT '目的IP',
  `ids_app_srcip` varchar(32) NOT NULL COMMENT '源IP',
  `ids_app_destport` varchar(32) NOT NULL COMMENT '目的端口',
  `ids_proto` varchar(32) NOT NULL COMMENT '协议类型',
  `ids_req_time` datetime NOT NULL COMMENT '请求时间',
  `ids_severity` int(11) NOT NULL COMMENT '威胁等级',
  `ids_signature` varchar(255) NOT NULL COMMENT '威胁类型',
  `ids_app_srcport` varchar(32) NOT NULL COMMENT '源端口',
  `ids_createtime` datetime NOT NULL COMMENT '入库时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='IDS攻击记录';

-- ----------------------------
-- Table structure for w3_kubernetes_assets
-- ----------------------------
DROP TABLE IF EXISTS `w3_kubernetes_assets`;
CREATE TABLE `w3_kubernetes_assets` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `kubernetes_id` bigint(20) NOT NULL COMMENT '集群配置的ID',
  `kubernetes_service_name` varchar(255) NOT NULL COMMENT '集群服务名称',
  `kubernetes_namespace` varchar(255) NOT NULL COMMENT '集群namespace',
  `kubernetes_tags` varchar(255) DEFAULT NULL COMMENT '集群服务的tags',
  `kubernetes_service_updatetime` datetime DEFAULT NULL COMMENT '更新时间',
  `kubernetes_service_createtime` datetime NOT NULL COMMENT '创建时间',
  `kubernetes_service_delete` tinyint(1) DEFAULT '1' COMMENT '删除状态,0:删除,1:启用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='K8S集群抓取的资产数据';

-- ----------------------------
-- Table structure for w3_kubernetes_config
-- ----------------------------
DROP TABLE IF EXISTS `w3_kubernetes_config`;
CREATE TABLE `w3_kubernetes_config` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `kubernetes_config_kub` varchar(255) DEFAULT '1' COMMENT 'kubeconfig配置',
  `kubernetes_config_status` tinyint(1) DEFAULT '1' COMMENT '状态,0:停用,1:启用',
  `kubernetes_config_delete_status` tinyint(1) DEFAULT '1' COMMENT '删除状态,0:删除,1:启用',
  `kubernetes_config_updatetime` datetime DEFAULT NULL COMMENT '更新时间',
  `kubernetes_config_createtime` datetime NOT NULL COMMENT '创建时间',
  `kubernetes_create_userid` bigint(20) NOT NULL COMMENT '创建的用户ID',
  `kubernetes_config_errormsg` varchar(255) DEFAULT NULL COMMENT '异常原因',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='kubernetes配置';

-- ----------------------------
-- Table structure for w3_license
-- ----------------------------
DROP TABLE IF EXISTS `w3_license`;
CREATE TABLE `w3_license` (
  `id` tinyint(1) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `license_type` tinyint(1) DEFAULT '1' COMMENT '类型,1:License版本,2:License内容',
  `lincese_info` char(32) DEFAULT '' COMMENT 'License内容',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='License管理';

-- ----------------------------
-- Table structure for w3_secrets
-- ----------------------------
DROP TABLE IF EXISTS `w3_secrets`;
CREATE TABLE `w3_secrets` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `secret_name` varchar(68) NOT NULL COMMENT '授权备注',
  `access_key` varchar(50) NOT NULL COMMENT 'AccessKeyId',
  `access_token` varchar(50) NOT NULL COMMENT 'AccessSecret',
  `secret_status` tinyint(1) DEFAULT '1' COMMENT '状态,0:停用,1:启用',
  `secret_delete` tinyint(1) DEFAULT '1' COMMENT '删除状态,0:删除,1:启用',
  `secret_create_userid` bigint(20) NOT NULL COMMENT '归属用户的ID',
  `secret_updatetime` datetime DEFAULT NULL COMMENT '更新时间',
  `secret_createtime` datetime NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='授权秘钥管理';

-- ----------------------------
-- Table structure for w3_spider_config
-- ----------------------------
DROP TABLE IF EXISTS `w3_spider_config`;
CREATE TABLE `w3_spider_config` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `spider_config` tinyint(1) DEFAULT '0' COMMENT '抓取类型,0:云上资产,1:K8S数据,2:Git数据',
  `spider_crontab_type` tinyint(1) DEFAULT '0' COMMENT '抓取频率,0:每分钟,1:每小时,2:每天',
  `spider_id` bigint(20) NOT NULL COMMENT '对应的ID',
  `spider_status` tinyint(1) DEFAULT '1' COMMENT '抓取状态,0:删除,1:启用',
  `spider_updatetime` datetime DEFAULT NULL COMMENT '更新时间',
  `spider_createtime` datetime NOT NULL COMMENT '创建时间',
  `spider_delete` tinyint(1) DEFAULT '1' COMMENT '删除状态,0:删除,1:启用',
  `spider_create_userid` bigint(20) NOT NULL COMMENT '创建的用户ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='抓取配置表';

-- ----------------------------
-- Table structure for w3_statistics
-- ----------------------------
DROP TABLE IF EXISTS `w3_statistics`;
CREATE TABLE `w3_statistics` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `statis_uptime` datetime DEFAULT NULL COMMENT '创建/更新时间',
  `statis_type` tinyint(1) DEFAULT '0' COMMENT '类型，0：审计日志数、1：识别攻击数、2：审计网络请求数,3:识别网络风险数',
  `statis_counts` bigint(20) DEFAULT '0' COMMENT '统计数',
  `website_id` bigint(20) NOT NULL COMMENT '站点归属ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='数据统计表';

-- ----------------------------
-- Table structure for w3_users
-- ----------------------------
DROP TABLE IF EXISTS `w3_users`;
CREATE TABLE `w3_users` (
  `user_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `user_name` varchar(25) NOT NULL COMMENT '用户名',
  `user_password` char(32) NOT NULL COMMENT '密码',
  `user_createtime` datetime NOT NULL COMMENT '创建时间',
  `user_updatetime` datetime DEFAULT NULL COMMENT '最后更新/登录时间',
  `user_status` tinyint(1) DEFAULT '1' COMMENT '规则状态,0：禁用，1：启用',
  `user_delete` tinyint(1) DEFAULT '1' COMMENT '逻辑删除状态,0：已删除，1：启用',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Table structure for w3_vuls_circulation
-- ----------------------------
DROP TABLE IF EXISTS `w3_vuls_circulation`;
CREATE TABLE `w3_vuls_circulation` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `vid` bigint(20) NOT NULL COMMENT 'id',
  `vul_circulation_createtime` datetime NOT NULL COMMENT '流转时间',
  `vul_dispose_status` tinyint(1) DEFAULT '0' COMMENT '处置状态,0:待处理,1:解决中,2:误报忽略,3:已解决,4:白名单,5:无效单,6:修改',
  `vul_circulation_info` varchar(255) DEFAULT '暂无' COMMENT '流转信息',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='漏洞管理.流转单';

-- ----------------------------
-- Table structure for w3_vuls_service
-- ----------------------------
DROP TABLE IF EXISTS `w3_vuls_service`;
CREATE TABLE `w3_vuls_service` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `vul_id` varchar(25) NOT NULL COMMENT '漏洞编号',
  `vul_name` varchar(255) DEFAULT '' COMMENT '漏洞名称',
  `vul_createtime` datetime NOT NULL COMMENT '创建时间',
  `vul_updatetime` datetime DEFAULT NULL COMMENT '更新时间',
  `vul_solvetime` datetime DEFAULT NULL COMMENT '解决时间',
  `vul_info` longtext NOT NULL COMMENT '漏洞信息',
  `vul_suggestion` longtext COMMENT '解决建议',
  `vul_referer` longtext COMMENT '引用参考',
  `vul_level` tinyint(1) DEFAULT '0' COMMENT '漏洞级别,0:低危,1:中危,2:高危',
  `vul_source` tinyint(1) DEFAULT '0' COMMENT '漏洞来源,0:内部,1:第三方',
  `vul_source_object` tinyint(1) DEFAULT '0' COMMENT '漏洞来源对象,0:人工,1:工具检测,2:公司名,3:白帽子',
  `vul_source_info` varchar(255) DEFAULT NULL COMMENT '漏洞来源对象内容',
  `vul_dispose_status` tinyint(1) DEFAULT '0' COMMENT '处置状态,0:待处理,1:解决中,2:误报忽略,3:已解决,4:白名单',
  `vul_circulation` tinyint(1) DEFAULT '0' COMMENT '内部流转,0:未接入,1:接入',
  `vul_delete` tinyint(1) DEFAULT '1' COMMENT '逻辑删除,0:已删除,1:正常',
  `vul_tags` varchar(255) DEFAULT '' COMMENT '漏洞标签,用,号分开',
  `vul_uuid` bigint(20) DEFAULT '0' COMMENT '漏洞创建人，如果是工具，默认为0',
  `vul_hosts` bigint(20) NOT NULL COMMENT '漏洞归属站点的ID',
  PRIMARY KEY (`id`,`vul_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='漏洞管理';

-- ----------------------------
-- Table structure for w3_vuls_tags
-- ----------------------------
DROP TABLE IF EXISTS `w3_vuls_tags`;
CREATE TABLE `w3_vuls_tags` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `vul_tags` varchar(30) NOT NULL COMMENT '漏洞标签',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='漏洞管理.风险标签';

-- ----------------------------
-- Table structure for w3_water_targes
-- ----------------------------
DROP TABLE IF EXISTS `w3_water_targes`;
CREATE TABLE `w3_water_targes` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `apps_website_id` bigint(20) NOT NULL COMMENT '站点ID',
  `apps_water_types` char(50) NOT NULL COMMENT '水位类型',
  `apps_water_counts` int(11) NOT NULL COMMENT '水位数字',
  `apps_water_updatetime` datetime NOT NULL COMMENT '水位更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='站点水位设定';

-- ----------------------------
-- Table structure for w3_web_attack_rules
-- ----------------------------
DROP TABLE IF EXISTS `w3_web_attack_rules`;
CREATE TABLE `w3_web_attack_rules` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '规则id',
  `rules_name` varchar(50) NOT NULL COMMENT '规则名称',
  `rules_level` tinyint(1) DEFAULT '0' COMMENT '风险级别,0:低危,1:中危,2:高危',
  `rules_trigger_count` bigint(20) DEFAULT '0' COMMENT '触发量',
  `rules_createtime` datetime NOT NULL COMMENT '创建时间',
  `rules_updatetime` datetime DEFAULT NULL COMMENT '更新时间',
  `rules_status` tinyint(1) DEFAULT '0' COMMENT '规则状态,0：待启用，1：启用，2：禁用，3：异常',
  `rules_delete` tinyint(1) DEFAULT '1' COMMENT '逻辑删除状态,0：已删除，1：启用',
  `rules_regex` longtext NOT NULL COMMENT '规则内容',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='web检测规则';

-- ----------------------------
-- Table structure for w3_web_attacks
-- ----------------------------
DROP TABLE IF EXISTS `w3_web_attacks`;
CREATE TABLE `w3_web_attacks` (
  `attack_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `attack_createtime` datetime NOT NULL COMMENT '事件时间',
  `attack_method` tinyint(1) NOT NULL COMMENT '事件请求类型,0:GET,1:POST,2:PUT,3:DELETE,4:HEAD,5:OPTIONS,6:TRACE,7:CONNECT,8:PATCH',
  `attack_source_ip` varchar(15) NOT NULL COMMENT '事件源IP',
  `attack_risk_level` tinyint(1) NOT NULL COMMENT '风险等级,0:低危,1:中危,2:高危,3:严重',
  `attack_hosts` varchar(255) DEFAULT '' COMMENT '目标业务',
  `attack_rules_id` bigint(20) NOT NULL COMMENT '攻击规则的ID',
  `attack_http_code` varchar(4) NOT NULL COMMENT '响应头',
  `attack_referer` varchar(255) DEFAULT '' COMMENT '请求referer来源',
  `attack_ua` text COMMENT 'Useragent',
  `attack_path` text COMMENT '攻击路径',
  `attack_body` text COMMENT 'POST请求的内容',
  `attack_sent_bytes` int(11) DEFAULT '0' COMMENT '报文大小',
  `attack_sent_time` varchar(15) DEFAULT '0.000' COMMENT '请求耗时',
  `attack_effective` tinyint(1) DEFAULT '0' COMMENT '处置状态,0:待处置,1:确认攻击,2:确认误报',
  `attack_area` varchar(10) DEFAULT '未知' COMMENT '归属地区',
  `attack_judge` varchar(255) DEFAULT '暂无' COMMENT '判定备注',
  PRIMARY KEY (`attack_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='攻击日志信息';

-- ----------------------------
-- Table structure for w3_web_attacks_circulation
-- ----------------------------
DROP TABLE IF EXISTS `w3_web_attacks_circulation`;
CREATE TABLE `w3_web_attacks_circulation` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `attack_id` bigint(20) NOT NULL COMMENT 'id',
  `attack_circulation_createtime` datetime NOT NULL COMMENT '流转时间',
  `attack_circulation_logs` varchar(255) DEFAULT '暂无' COMMENT '流转信息',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='攻击日志信息.流转单';

-- ----------------------------
-- Table structure for w3_webscan_base_config
-- ----------------------------
DROP TABLE IF EXISTS `w3_webscan_base_config`;
CREATE TABLE `w3_webscan_base_config` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `webscan_config_string_info` text COMMENT '配置内容(字符串型)',
  `webscan_config_type` tinyint(1) DEFAULT '0' COMMENT '配置类型,0:爬取深度,1:扫描并发数,2:扫描请求useragent,3:扫描插件,4:云翻译',
  `webscan_config_int_info` int(11) DEFAULT '0' COMMENT '配置内容(数字型)',
  `webscan_config_updatetime` datetime DEFAULT NULL COMMENT '配置创建/更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='web扫描设置';

-- ----------------------------
-- Table structure for w3_website
-- ----------------------------
DROP TABLE IF EXISTS `w3_website`;
CREATE TABLE `w3_website` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `website_name` char(100) NOT NULL COMMENT '站点应用名称',
  `website_domain` char(100) NOT NULL COMMENT '站点域名',
  `website_info` char(100) DEFAULT NULL COMMENT '站点应用备注',
  `website_createtime` datetime NOT NULL COMMENT '创建时间',
  `website_updatetime` datetime DEFAULT NULL COMMENT '更新时间',
  `website_delete` tinyint(1) DEFAULT '1' COMMENT '逻辑删除,0:删除，1:可用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='站点管理';

-- ----------------------------
-- Table structure for w3_website_config
-- ----------------------------
DROP TABLE IF EXISTS `w3_website_config`;
CREATE TABLE `w3_website_config` (
  `id` bigint(20) NOT NULL COMMENT 'id',
  `website_log_ipdomain` varchar(100) NOT NULL COMMENT 'ES的IP或域名',
  `website_log_port` int(11) DEFAULT '0' COMMENT 'ES的端口',
  `website_log_protype` tinyint(1) DEFAULT '0' COMMENT 'ES的协议，HTTP/HTTPS',
  `website_log_idslog_index` varchar(100) DEFAULT NULL COMMENT 'ids日志索引',
  `website_log_weblog_index` varchar(100) DEFAULT NULL COMMENT 'web日志索引',
  `website_createtime` datetime NOT NULL COMMENT '创建时间',
  `website_updatetime` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`,`website_log_ipdomain`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='站点管理.配置站点';

-- ----------------------------
-- Table structure for w3_website_service
-- ----------------------------
DROP TABLE IF EXISTS `w3_website_service`;
CREATE TABLE `w3_website_service` (
  `id` bigint(20) NOT NULL COMMENT 'id',
  `website_types` tinyint(1) NOT NULL DEFAULT '0' COMMENT '服务开启类型,0:可用性监控,1:流量监控,2:篡改监控,3:Web日志监控',
  `website_createtime` datetime NOT NULL COMMENT '创建时间',
  `website_updatetime` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`,`website_types`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='站点管理.服务配置';

SET FOREIGN_KEY_CHECKS = 1;


/**
 * 初始化数据
 */
-- ----------------------------
-- License管理(默认都是社区版)
-- ----------------------------
INSERT INTO `w3a_soc`.`w3_license`(`id`, `license_type`, `lincese_info`) VALUES (1, 1, '社区版');
INSERT INTO `w3a_soc`.`w3_license`(`id`, `license_type`, `lincese_info`) VALUES (2, 2, '无');
-- ----------------------------
-- 创建测试账号密码
-- ----------------------------
INSERT INTO `w3a_soc`.`w3_users`(`user_name`,`user_password`,`user_createtime`)VALUES('admin','385ba8ba360a0efbf17c93784323f655', now());
-- ----------------------------
-- ----------------------------
-- 创建测试规则数据
-- ----------------------------
INSERT INTO `w3a_soc`.`w3_web_attack_rules`(`id`, `rules_name`, `rules_level`, `rules_trigger_count`, `rules_createtime`, `rules_updatetime`, `rules_status`, `rules_delete`, `rules_regex`) VALUES (1, 'SQL注入-探测', 2, 0, now(), NULL, 1, 1, 'KD9pKShhbmR8b3IpKC4qKVxkPVxk');
INSERT INTO `w3a_soc`.`w3_web_attack_rules`(`id`, `rules_name`, `rules_level`, `rules_trigger_count`, `rules_createtime`, `rules_updatetime`, `rules_status`, `rules_delete`, `rules_regex`) VALUES (2, 'PHP敏感目录扫描', 0, 0, now(), NULL, 1, 1, 'KD9pKSh3cC1sb2dpbnxjbWR8YWRtaW58cGhwaW5mbylcLnBocA==');
INSERT INTO `w3a_soc`.`w3_web_attack_rules`(`id`, `rules_name`, `rules_level`, `rules_trigger_count`, `rules_createtime`, `rules_updatetime`, `rules_status`, `rules_delete`, `rules_regex`) VALUES (3, '链路跟踪探针探测', 0, 0, now(), NULL, 1, 1, 'KD9pKSh0cmFjZXx0cmFjZWluZyk=');
INSERT INTO `w3a_soc`.`w3_web_attack_rules`(`id`, `rules_name`, `rules_level`, `rules_trigger_count`, `rules_createtime`, `rules_updatetime`, `rules_status`, `rules_delete`, `rules_regex`) VALUES (4, 'SQL注入-UNION', 2, 0, now(), NULL, 1, 1, 'KC4qKSg/aSkodW5pb24pKC4qKSg/aSkoc2VsZWN0KQ==');
INSERT INTO `w3a_soc`.`w3_web_attack_rules`(`id`, `rules_name`, `rules_level`, `rules_trigger_count`, `rules_createtime`, `rules_updatetime`, `rules_status`, `rules_delete`, `rules_regex`) VALUES (5, 'composer文件泄露探测', 0, 0, now(), NULL, 1, 1, 'KD9pKVwuKGNvbXBvc2VyXC9jb21wb3NlclwuanNvbik=');
INSERT INTO `w3a_soc`.`w3_web_attack_rules`(`id`, `rules_name`, `rules_level`, `rules_trigger_count`, `rules_createtime`, `rules_updatetime`, `rules_status`, `rules_delete`, `rules_regex`) VALUES (6, 'Jira版本探测', 0, 0, now(), NULL, 1, 1, 'XC8oP2kpc2VjdXJlXC8oP2kpRGFzaGJvYXJkXC5qc3Bh');
INSERT INTO `w3a_soc`.`w3_web_attack_rules`(`id`, `rules_name`, `rules_level`, `rules_trigger_count`, `rules_createtime`, `rules_updatetime`, `rules_status`, `rules_delete`, `rules_regex`) VALUES (7, '后门地址', 1, 0, now(), NULL, 1, 1, 'KD9pKShjbWR8YmFja2Rvb3J8MXx0ZXN0fHBocGluZm98cGhwfGpzcClcLihwaHB8anNwfGFzcHh8YXNwKQ==');
INSERT INTO `w3a_soc`.`w3_web_attack_rules`(`id`, `rules_name`, `rules_level`, `rules_trigger_count`, `rules_createtime`, `rules_updatetime`, `rules_status`, `rules_delete`, `rules_regex`) VALUES (8, '本地文件包含', 2, 0, now(), NULL, 1, 1, 'XC8oP2kpKGV0Y3xwYXNzd2R8d2luZG93c1wvd2luKQ==');
INSERT INTO `w3a_soc`.`w3_web_attack_rules`(`id`, `rules_name`, `rules_level`, `rules_trigger_count`, `rules_createtime`, `rules_updatetime`, `rules_status`, `rules_delete`, `rules_regex`) VALUES (9, '远程命令执行', 2, 0, now(), NULL, 1, 1, 'KD9pKShkZWZpbmV8ZXZhbHxmaWxlX2dldF9jb250ZW50c3xpbmNsdWRlfHJlcXVpcmV8cmVxdWlyZV9vbmNlfHNoZWxsX2V4ZWN8cGhwaW5mb3xzeXN0ZW18cGFzc3RocnV8Y2hhcnxjaHJ8ZXhlY3V0ZXxlY2hvfHByaW50fHByaW50X3J8dmFyX2R1bXB8b3BlbikoLiop');
INSERT INTO `w3a_soc`.`w3_web_attack_rules`(`id`, `rules_name`, `rules_level`, `rules_trigger_count`, `rules_createtime`, `rules_updatetime`, `rules_status`, `rules_delete`, `rules_regex`) VALUES (10, '弱口令探测', 2, 0, now(), NULL, 1, 1, 'KD9pKShwYXNzd29yZHxwYXNzfHBhc3N3ZHxwd2R8cGR8dXNlcnB3ZHx1c2VycGFzc3x1c2VycGFzc3dkfHVzZXJwYXNzd29yZHxwYXNzX3dvcmR8dXNlcl9wYXNzd29yZHx1c2VyX3Bhc3MpXD0oP2kpKGFkbWlufGFkbWluMTIzfGFkbWluMTIzNDU2fDEyMzQ1NnxhZG1pbjg4OHxhZG1pbjg4ODh8dGVzdHwxMjM0fDEyM3x0ZXN0MTIzKQ==');
INSERT INTO `w3a_soc`.`w3_web_attack_rules`(`id`, `rules_name`, `rules_level`, `rules_trigger_count`, `rules_createtime`, `rules_updatetime`, `rules_status`, `rules_delete`, `rules_regex`) VALUES (11, 'XSS跨站脚本攻击', 2, 0, now(), NULL, 1, 1, 'XDwoP2kpc2NyaXB0XD4oP2kpYWxlcnRcKCguKilcKVw8XC8oP2kpc2NyaXB0XD4=');

-- ----------------------------
-- web漏洞扫描
-- ----------------------------
INSERT INTO `w3a_soc`.`w3_webscan_base_config`(`id`, `webscan_config_string_info`, `webscan_config_type`, `webscan_config_int_info`, `webscan_config_updatetime`) VALUES (1, 'allowed_methods, backdoors, backup_directories, backup_files, captcha, code_injection, code_injection_php_input_wrapper, code_injection_timing, common_admin_interfaces, common_directories, common_files, cookie_set_for_parent_domain, credit_card, csrf, cvs_svn_users, directory_listing, emails, file_inclusion, form_upload, hsts, htaccess_limit, html_objects, http_only_cookies, http_put, insecure_client_access_policy, insecure_cookies, insecure_cors_policy, insecure_cross_domain_policy_access, insecure_cross_domain_policy_headers, interesting_responses, ldap_injection, localstart_asp, mixed_resource, no_sql_injection, no_sql_injection_differential, origin_spoof_access_restriction_bypass, os_cmd_injection, os_cmd_injection_timing, password_autocomplete, path_traversal, private_ip, response_splitting, rfi, session_fixation, source_code_disclosure, sql_injection, sql_injection_differential, sql_injection_timing, ssn, trainer, unencrypted_password_forms, unvalidated_redirect, unvalidated_redirect_dom, webdav, x_frame_options, xpath_injection, xss, xss_dom, xss_dom_script_context, xss_event, xss_path, xss_script_context, xss_tag, xst, xxe', 3, 0, now());
INSERT INTO `w3a_soc`.`w3_webscan_base_config`(`id`, `webscan_config_string_info`, `webscan_config_type`, `webscan_config_int_info`, `webscan_config_updatetime`) VALUES (2, NULL, 0, 4, now());
INSERT INTO `w3a_soc`.`w3_webscan_base_config`(`id`, `webscan_config_string_info`, `webscan_config_type`, `webscan_config_int_info`, `webscan_config_updatetime`) VALUES (3, NULL, 1, 10, now());
INSERT INTO `w3a_soc`.`w3_webscan_base_config`(`id`, `webscan_config_string_info`, `webscan_config_type`, `webscan_config_int_info`, `webscan_config_updatetime`) VALUES (4, 'Baiduspider+(+http://www.baidu.com/search/spider.htm)', 2, 0, now());
INSERT INTO `w3a_soc`.`w3_webscan_base_config`(`id`, `webscan_config_string_info`, `webscan_config_type`, `webscan_config_int_info`, `webscan_config_updatetime`) VALUES (5, NULL, 4, 0, now());

SET FOREIGN_KEY_CHECKS = 1;
