
<p align="center"><img style="width:660px" title="Run example" alt="Run example" src="/WechatIMG204 .png"></p>

<p align="center">
基于应用网络监控、Web、系统日志审计一体化的平台。<br>
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
- 日志分析: 基于kafka+GoLang的方式，对采集的Web和系统应用日志进行攻击行为的分析。
- 篡改监控: 基于Golang开发的页面篡改监控。 
- 漏洞管理：在线托管所有漏洞，可以用于打通内部工作流的汇聚。
- 业务连续性监控: 基于网络的业务连续性监控服务，确定业务是否有中断。
- 告警整合: 实现钉钉、企业微信的联动告警机制。
- 部署支持：docker-compose、Kubernetes。
- 整体架构：基于 Filebeat(采集/清洗) + Kafka(汇聚) + ElasticSearch(检索)
- 技术实现：后端基于Java，前端基于Vue，数据库基于MYSQL。

**目标**
- 满足等保二级、三级的需求，直接部署就能用那种。
- 让客户少花钱，然后也能用，不串联到业务中，对业务0影响。
- 部署简单，一键部署，或者直接随着元豚科技生态自动部署。

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

### 备注

- 一直以来都有人问我到底还是否继续更新迭代，不断有人加我，还给我鼓励，时隔六年，沉淀积累之后，准备再做一套新的，可以持续更新维护的版本。
- 这个产品会并入「元豚科技」下，有需要可以使用「元豚科技」的部署产品，给元豚的客户提供价值。
- 诸位发现问题请直接提交issue，如果有定制化需求，麻烦支持下收费版本，在内部推动下元豚科技的产品啥的，感激不尽。
- 项目元豚科技接管之后，起码不会荒废，只要公司一直在，项目就会更新。
- 北京地区，找元豚科技做等级保护二、三级免费使用元豚旗下产品的商业版、社区版。
- 旧的版本在release，那个版本是开源的，代码开放，有需要自行提取。

### 客户体验计划

- 欢迎种子用户，早期的种子用户后期可以优先体验商业版功能，欢迎扫码加我微信，我后面拉群。
- 欢迎提意见和场景，我们想办法满足，如果有好的日志样本也可以提供给我们。

### 欢迎加群

<img style="width:200px" title="Run example" alt="Run example" src="/WechatIMG211.jpeg">

