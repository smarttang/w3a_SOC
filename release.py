#coding:utf-8

# 脚本是为了加快我发布的速度而生
# 之前发布太费劲了

import os
from shutil import copyfile
import sys

class ReleaseJobs:

	def __init__(self, argv):
		self.baseHome = os.getcwd()
		self.version = argv[1]
		self.jarPath = [
			{'path':'../../test/source/w3a-soc-center/w3a-dashboard-service/target/', 'name':'w3a-dashboard-service', 'dist':'./backend/dashboard/', 'report':'registry.cn-beijing.aliyuncs.com/aidolphins_com/w3a-dashboard:'},
			{'path':'../../test/source/w3a-soc-center/w3a-openapi-service/target/', 'name':'w3a-openapi-service', 'dist':'./backend/openapi/', 'report':'registry.cn-beijing.aliyuncs.com/aidolphins_com/w3a-openapi:'},
			{'path':'../../test/source/w3a-soc-center/w3a-workerapi-service/target/', 'name':'w3a-workerapi-service', 'dist':'./backend/workapi/', 'report':'registry.cn-beijing.aliyuncs.com/aidolphins_com/w3a-workapi:'},
		]

		self.dockerHub = []

	def copyJar(self):
		'''
			构建后盾
		'''
		for jarPathItems in self.jarPath:
			copyfile(jarPathItems['path']+jarPathItems['name']+"-0.0.1-SNAPSHOT.jar", jarPathItems['dist']+'release.jar')
			# 切换目录进行构建
			os.chdir(jarPathItems['dist'])
			os.system("./run.sh "+self.version)
			os.system("rm -rf release.jar")
			self.dockerHub.append(jarPathItems['report']+self.version)
			# 回到原来目录
			os.chdir(self.baseHome)


	def copyGolang(self):
		'''

			构建工具端
		'''
		os.chdir("../../test/source/w3a-soc-agent")
		os.system("./run.sh "+self.version)
		os.chdir(self.baseHome)
		self.dockerHub.append("registry.cn-beijing.aliyuncs.com/aidolphins_com/w3a-agent:"+self.version)

	def copyFrontend(self):
		'''
			构建前端
		'''
		os.chdir("../../test/source/w3a-soc-frontend/")
		os.system("npm run build:prod")
		os.system("tar zcvf w3a-soc-frontend.tar.gz dist/")
		os.system("rm -rf dist/")
		os.chdir(self.baseHome)
		copyfile("../../test/source/w3a-soc-frontend/w3a-soc-frontend.tar.gz", "./frontend/release.tar.gz")
		os.system("rm -rf ../../test/source/w3a-soc-frontend/w3a-soc-frontend.tar.gz")
		os.chdir("./frontend/")
		os.system("tar xvf release.tar.gz")
		os.system("./run.sh "+self.version)
		os.system("rm -rf dist/")
		os.system("rm -rf release.tar.gz")
		os.chdir(self.baseHome)
		self.dockerHub.append("registry.cn-beijing.aliyuncs.com/aidolphins_com/w3a-frontend:"+self.version)

if __name__ == '__main__':
	t = ReleaseJobs(sys.argv)
	t.copyJar()
	t.copyGolang()
	t.copyFrontend()

	print("[*]构建完成:")
	for item in t.dockerHub:
		print item
