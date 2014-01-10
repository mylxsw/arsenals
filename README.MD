#Arsenals 开发文档
**版本号： 1.0**  
**作者： 管宜尧**  
***2014/1/4 0:04:56***

##第一章 架构指南
Arsenals采用了基于MVC的架构，同时支持Service层的扩展。  
- **控制器（controller)**  
	控制器主要负责处理用户的请求，选择相应的Service层或者是模型层对用户的请求进行处理,并负责选择视图展示需要输出的内容。  
- **服务层（service）**  
	服务层是可选的，完成系统业务逻辑的处理。  
- **模型层（model）** *可选*  
	在没有服务层的情况下，模型层完成业务逻辑的处理并对数据库操作进行处理，在服务层存在的情况下，模型层主要负责与数据库之间进行交互，为Service层实现与下层数据库的交互，而让Service层只关注业务逻辑的处理。  
- **视图层（view）**  
	视图层负责页面内容的展示，将模型的数据进行渲染，生成HTML或者json格式的数据返回给客户端，用户最终内容的展示。  
- **过滤器（filter）**
	过滤器类似于java servlet中的Filter，用户对用户请求处理前后进行预处理，如权限控制、异常处理等。


系统采用了 *PHP 5.3* 开始支持的 **命名空间** ，在开发过程中，可以实现业务代码的灵活组织，非常简单的实现 ***HMVC*** 架构，以便对业务逻辑进行分离，更加清晰的实现模块化的开发。  



##第二章 开发规范

####命名规范  

1. 对于类，采用驼峰命名法进行命名，如`SessionUtils`
2. 对于成员变量，变量，采用_分割的小写方式命名，如`$cate_name`
3. 对于方法，采用首字母小写的驼峰命名， 如`getUserName()`
4. 普通函数采用小写加_的命名方法，如`function _exception_handler()`
4. 对于PHP常量，采用大写，如`define('BASE_PATH', '\\')`
5. 在PHP类中，如果成员是private或者protected的，则在名称前加一个 **\_** ，如`protected function _output()`
6. 文件命名，所有的类文件命名以含有的类名为准，比如类`SessionUtils`所在的PHP文件应该命名为 ***SessionUtils.php*** , 不要使用类似SessionUtils.class.php等格式的命名，自动加载机制无法加载此种命名方法。



##第三章 快速入门

###常量定义
<table>
	<thead>
		<tr><th>常量</th><th>用途</th></tr>
	</thead>
	<tbody>
	<tr>
		<td>APP_PATH</td><td>项目路径</td>
	</tr>
	<tr>
		<td>CONFIG_PATH</td><td>配置文件所在路径</td>
	</tr>
	<tr>
		<td>VIEW_PATH</td><td>视图所在路径</td>
	</tr>
	<tr>
		<td>VIEW_LAYER</td><td>采用的视图实现，默认是SimpleView，值为带有命名空间的试图实现名称</td>
	</tr>
	<tr>
		<td>MODEL_NAMESPACE</td><td>模型命名空间</td>
	</tr>
	<tr>
		<td>SERVICE_NAMESPACE</td><td>服务层命名空间</td>
	</tr>
	<tr>
		<td>CONTROLLER_NAMESPACE</td><td>控制层命名空间</td>
	</tr>
	<tr>
		<td>FILTER_NAMESPACE</td><td>过滤器命名空间</td>
	</tr>
	</tbody>
</table>

###项目配置

####基本配置config.php
<table>
<thead>
	<tr><th>配置项</th><th>默认值</th><th>作用</th></tr>
</thead>
<tbody>
	<tr>
		<td>theme</td>
		<td>defaults</td>
		<td>默认主题</td>
	</tr>
	<tr>
		<td>site_url</td>
		<td></td>
		<td>站点访问地址</td>
	</tr>
	<tr>
		<td>hook_enabled</td>
		<td>false</td>
		<td>是否允许钩子调用</td>
	</tr>
</tbody>
</table>

####数据库配置database.php
<table>
<thead>
	<tr><th>配置项</th><th>默认值</th><th>作用</th></tr>
</thead>
<tbody>
	<tr>
		<td>data_source</td>
		<td>Arsenals\\Core\\Database\\MySQL\\MySQLiDataSource</td>
		<td>默认采用的数据源</td>
	</tr>
	<tr>
		<td>global</td>
		<td>array('prefix')</td>
		<td>数据库访问全局配置</td>
	</tr>
	<tr>
		<td>mysql</td>
		<td>array('host','port','db_name','user','password','char_set','dbcollat')</td>
		<td>mysql连接配置</td>
	</tr>
	<tr>
		<td>pdo</td>
		<td>array('dsn','user','password')</td>
		<td>PDO连接配置</td>
	</tr>
</tbody>
</table>

####路由配置router.php
<table>
<thead>
	<tr><th>配置项</th><th>默认值</th><th>作用</th></tr>
</thead>
<tbody>
	<tr>
		<td>default_controller</td>
		<td>Index</td>
		<td>默认控制器</td>
	</tr>
	<tr>
		<td>default_action</td>
		<td>index</td>
		<td>默认访问的方法</td>
	</tr>
</tbody>
</table>

###钩子
<table>
<thead>
	<tr><th>挂载点</th><th>用途</th></tr>
</thead>
<tbody>
	<tr>
		<td>before_system</td>
		<td>系统初始化之前</td>
	</tr>
	<tr>
		<td>after_system</td>
		<td>系统初始化之后</td>
	</tr>
	<tr>
		<td>before_controller_init</td>
		<td>控制器初始化之前</td>
	</tr>
	<tr>
		<td>after_controller_init</td>
		<td>控制器初始化之后</td>
	</tr>
	<tr>
		<td>before_action</td>
		<td>控制器动作执行之前</td>
	</tr>
	<tr>
		<td>after_action</td>
		<td>控制器动作执行之后</td>
	</tr>
</tbody>
</table>

###模板引擎
默认是采用系统内置的简单模板的，该模板使用纯PHP。  

可以通过在入口文件中定义常量 **VIEW_LAWER** 修改默认采用的模板引擎，默认值为： **Arsenals\Core\Views\SimpleView** ，采用纯PHP模板。
例如：  

```define('VIEW_LAYER', 'Arsenals\Core\Views\SimpleView');```  

系统还提供了一个基于Twig的模板引擎，不过需要手动加入Twig的类库才可以使用。加入Twig的类库之后，需要在项目的入口文件中定义Twig的Autoloader.php文件的路径常量，如下所示：  

```define('TWIG_LIB', 'Twig所在目录/Autoloader.php');```

接下来再配置VIEW_LAWER值为 **'Arsenals\Libraries\Twig\TwigView'** 即可。