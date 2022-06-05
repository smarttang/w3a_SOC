
<p align="center"><img style="width:660px" title="Run example" alt="Run example" src="/WechatIMG204 .png"></p>

<p align="center">
元豚科技 - 基于日志安全分析做切入，做最好用的「云原生安全运维工作台」<br>
</p>

![](https://img.shields.io/badge/golang-1.17.2%20-green)
![](https://img.shields.io/badge/openjdk-15.0.5-green)
![](https://img.shields.io/badge/W3A%20SOC-v2.0-green)
![](https://img.shields.io/badge/%E7%AD%89%E7%BA%A7%E4%BF%9D%E6%8A%A4%E4%B8%89%E7%BA%A7-%E6%97%A5%E5%BF%97%E5%AE%A1%E8%AE%A1-green)
![](https://img.shields.io/badge/%E5%91%8A%E8%AD%A6%E7%9B%91%E6%8E%A7-%E9%92%89%E9%92%89-green)
![](https://img.shields.io/badge/%E5%91%8A%E8%AD%A6%E7%9B%91%E6%8E%A7-%E4%BC%81%E4%B8%9A%E5%BE%AE%E4%BF%A1-green)
![](https://img.shields.io/badge/Kubernetes-1.20.6-green)
![](https://img.shields.io/badge/%20docker--compose-1.29.2-green)


**主要特性**
- 日志分析: 日志存放在Kafka，Agent结合规则匹配攻击行为，并上报到W3A SOC平台。
- 工程分析: 针对工程代码进行API分析、工程组成分析、组件扫描、静态代码漏洞检测等。
- Web漏洞扫描: 基于Arachni进行结合漏洞扫描，资产跟Web漏洞扫描联动巡检。
- 资产采集: 打通阿里云、腾讯云，采集云上资产（域名、云服务、容器等）进行快速收集、定时同步，摸清家底。
- 漏洞管理：在线托管所有漏洞，可以用于打通内部工作流的汇聚。
- 告警整合: 实现钉钉、企业微信的联动告警机制，统计攻击行为，联动。
- 流量分析：NIDS(Suricate)入侵检测支持，采集汇聚到工作台。

**特点/技术栈**
- 部署支持：docker-compose、Kubernetes。
- 整体架构：基于 Filebeat(采集/清洗) + Kafka(汇聚) + ElasticSearch(检索) + 各种第三方开源能力 + 自研的工具 + 云原生/物理机环境
- 技术实现：后端基于Java，前端基于Vue，数据库基于MYSQL、工具基于Golang。
- 业务融合：加入LDAP登录支持，可以并入业务单点登录SSO，融合同一套登录体系。

**目标**
- 满足安全合规需求、满足日常安全技术需求，帮助安全人员、安全负责人、运维负责人快速实现一体化安全运维工作台，助力快速做出成绩，达成KPI。
- 让客户少花钱，尽最大努力，把所有涉及到的安全基础设施做集成，开箱就用，无需再配置。
- 在云原生环境下，更加友好的支持业务的发展，满足云原生环境下缺失的安全闭环和短板。

### 部署文档

参考在线文档：http://w3asoc.aidolphins.com/

### DEMO

应用管理界面:(新版，以应用作为中心)

<img style="max-width:100%;" title="Run example" alt="Run example" src="/newpic/main.png">

大盘主界面:

<img style="max-width:100%;" title="Run example" alt="Run example" src="/newpic/dashboard.png">

规则管理主界面：

<img style="max-width:100%;" title="Run example" alt="Run example" src="/newpic/rules.png">

Web访问日志界面:

<img style="max-width:100%;" title="Run example" alt="Run example" src="/newpic/web.png">

攻击详情页面:

<img style="max-width:100%;" title="RUN" alt="RUN" src="/newpic/attack.png">

工程分析页面：

<img style="max-width:100%;" title="RUN" alt="RUN" src="/newpic/gongcheng.png">


### 备注

- 诸位发现问题请直接提交issue，如果有定制化需求，麻烦支持下收费版本，在内部推动下元豚科技的产品啥的，感激不尽。
- 项目元豚科技接管之后，起码不会荒废，只要公司一直在，项目就会更新。
- 北京地区，找元豚科技做等级保护二、三级免费使用元豚旗下产品的商业版、社区版。
- 旧的版本在release，那个版本是开源的，代码开放，有需要自行提取。

### 欢迎加群

<img style="width:200px" title="Run example" alt="Run example" src="/WechatIMG227.jpeg">

