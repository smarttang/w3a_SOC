

# W3A SOC

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
- 业务连续性监控: 基于网络的业务连续性监控服务，确定业务是否有中断。
- 告警整合: 实现钉钉、企业微信的联动告警机制。
- 部署支持：docker-compose、Kubernetes。
- 整体架构：基于 Filebeat(采集/清洗) + Kafka(汇聚) + ElasticSearch(检索)
- 技术实现：后端基于Java，前端基于Vue，数据库基于MYSQL。

**目标**
- 满足等保二级、三级的需求，直接部署就能用那种。
- 让客户少花钱，然后也能用，不串联到业务中，对业务0影响。
- 部署简单，一键部署，或者直接随着元豚科技生态自动部署。

### 关键能力细节

**Web日志分析**
- 通过Logstash/filebeat采集日志到ES上。
- Golang链接ES，实时分析日志。
- 将存在问题的部分直接存到平台里，平台只存落地的攻击日志、记录分析日志数。
- 攻击源IP地址分析，结合IP来源进行分析。
- 输出可以用于封禁的API接口，查可封禁的IP。

**存活监控/篡改监控告警**
- 针对提交的IP进行检测，看是否存活，可以分布式，持续的监测。
- 针对目标进行篡改监控。

**问题告警**
- 针对出现的问题，统一告警输出。
- 支持钉钉、企业微信。

### 部署文档

#### 非容器化部署（针对虚拟机、云服务器部署）

**清单**
- 后端：backend（w3a-dashboard-service-v1.jar, w3a-openapi-service-v1.jar）
- 工具端：tools（w3a-soc-agent [日志审计]）
- 前端：frontend (dist)
- 自备JavaJDK环境、Nginx、Kafka、Elasticsearch、Redis
- 针对Java端两个服务部署参考：（守护进程自己解决哈）
```shell
    java -Dspring.datasource.url="jdbc:mysql://[mysql的地址]:[端口]/w3a_soc?characterEncoding=utf-8&useSSL=false" \
        -Dspring.datasource.username=[数据库账号] \
        -Dspring.datasource.password=[数据库密码] \
        -Dspring.redis.host=[redis的地址] \
        -Dspring.redis.port=[redis端口] \
        -jar w3a-dashboard-service-v1.jar
```
- 针对工具端：（topic取决于你的采集器、kafka地址、端口自己部署配置，守护进程自己解决哈）
```shell
➜  w3a-soc-agent ./bin/w3a-soc-agent -h
Usage of ./bin/w3a-soc-agent:
  -A string
        日志归一的kafka的地址:端口,可以多个,以','分割,默认: kafka:9092 (default "kafka:9092")
  -T string
        日志归一的kafka的Topic名称,默认: weblogs (default "weblogs")
```

#### 容器化部署（针对ECS、CVM、本地、云主机等，docker-compose方式）

**步骤**
- 我都写好了，不需要你做啥，直接一键部署启动就行。
- 建议自己开台虚拟机，然后安装好docker-compose就行，其它不用干别的。
- 尽量不要乱动，我更新的时候会修改里面的镜像版本，每次你pull完代码之后，重新docker-compose起来的时候，都是用的最新的镜像。

```shell
  cd deploy/docker-compose/simple/
  docker-compose up -d
```

#### K8S部署（针对容器集群）
**步骤**
- 我都写好了，不需要你做啥，直接一键部署启动就行。
- 或者直接把Yaml贴到集群配置导入就行。

```shell
   kubectl create -f deploy/kubernetes/
```

### DEMO

新版本程序主界面:

<img style="max-width:100%;" title="Run example" alt="Run example" src="/newpic/EC31ED5A-D3FE-4581-A222-715D4C5A6239.png">


### 备注

- 一直以来都有人问我到底还是否继续更新迭代，不断有人加我，还给我鼓励，时隔六年，沉淀积累之后，准备再做一套新的，可以持续更新维护的版本。
- 以前的模式更多是靠自己兴趣驱动，现在更多是靠这个生存。
- 这个产品会并入「元豚科技」下，有需要可以使用「元豚科技」的部署产品，给元豚的客户提供价值。
- 诸位发现问题请直接提交issue，如果有定制化需求，麻烦支持下收费版本，在内部推动下元豚科技的产品啥的，感激不尽。
- 项目元豚科技接管之后，起码不会荒废，只要公司一直在，项目就会更新。
- 北京地区，找元豚科技做等级保护二、三级免费使用元豚旗下产品的商业版、社区版。
- 旧的版本在old文件夹里，可以自行研究，但不建议生产环境使用了。

### 客户体验计划

- 欢迎种子用户，早期的种子用户后期可以优先体验商业版功能，欢迎扫码加我微信，我后面拉群。
- 欢迎提意见和场景，我们想办法满足，如果有好的日志样本也可以提供给我们。
- 预计5.1之后发布一个测试版本。

### 加我

<img style="width:200px" title="Run example" alt="Run example" src="/newpic/wechat.png">

