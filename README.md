ProjectHooker
=====
衍生自: https://github.com/mdluo/github-webhook-handler-php  
WebHook升级版，增加了各种功能

# 目的
在服务器上面同时部署多个项目的时候希望只用部署一次Webhook就可以全部挂钩？
指令删改太麻烦？单文件耦合度太高？每次都要重新写一次脚本？
想要发送指令Log到其他地方？（Telegram）？  
这里应该有你想要的

# 特性
- 一次部署，后续只需要添加对应的配置文件和指令集即可
- 没有依赖需要（有点懒）
- 指令集可复用
- Post-Command Section, Log, etc...
- 觉得不够的话你可PR或者提issue看看能不能加咯

# 说明
- 调用地址： `/project/{Your Project Name}` 
我们在仓库内提供一些例子供你参考
## Config  
@TODO Be specific
包含：
 - secret    
  Webhook Secret  
 - path    
 Project Path 项目地址
 - logPath    
 Log Path, Empty means log will not be saved  日志地址，留空将不会保存  
 - templateVariable  
 Variable You want to define in the command  命令变量
 - commandPackage  
 Command package you want to run   
 - postCommandVariable   
   Post Command Variable  
 - postCommandPackage   
   Package that will Exec after finished commandPackage
   
## Command Package
  - Variable `$command`
  你想要执行的命令  
  **注意** 如果你希望command被你指定的Variable渲染，请使用双引号
### 编写Pack
  - 你的配置文件中的注册的变量`*Variable`都会被推广，所以你可以用`{$key}`获取到值
  - 其中，一部分基本变量`path`,`secret`会被默认推广，你可以直接调用，注册可以覆盖掉默认值
  - `$LogFilePath` 只能在`PostCommand`内调用，这是注册在`runtimeVariable`中的，如果你没有填写路径，这个变量将会返回`NULL`

## Log
 - `index.php` 内定义了Log的储存方式（默认JSON）
 - Log 是以 `runtimeVariable` 的形式代入到指令的Parse过程中

# @TODO
 - [ ] parse Payload 并使用`commit id`作为LOG名字
 - [ ] `index.php` 耦合性还是太高了
 - [ ] 安全性检查（尚未发现）

# 权限说明  
因为执行指令的用户和Apache或者Nginx权限是一层的，你需要让它拥有LOG目录/项目目录/你要执行的操作的权限，切记  
```bash
#if you are using Apache as web server, change `www-data` to `www`
chown -R www-data /path/to/the/repository/
chmod -R g+s /path/to/the/repository/
cd /path/to/the/repository/
sudo -u www-data git pull
```

# lisense
MIT

