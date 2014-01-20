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


##第三章 快速开始
本章主要介绍如何快速开始一个Arsenals项目的开发。  

- **目录结构**  
	建立你的项目目录，本例以Demo为例。
	<pre>
	Demo
	|-caches		缓存目录
	|-configs
		|-config.php  	项目基本配置
		|-database.php  数据库连接配置
		|-filter.php  	过滤器配置
		|-hook.php  	钩子配置
		|_router.php  	路由配置
	|-controllers		控制器
	|-filter		过滤器
	|-hooks			钩子目录
	|-models		模型
	|_views			视图
	</pre>
	实际上，该目录结构并不是必须的，除configs目录是固定之外，其余目录都会根据namespace进行寻找，因此，可以根据程序需要自定义文件存储结构（必须与命名空间相匹配的目录结构）。
- **入口文件**  
	项目的入口文件 ```index.php```
	<pre>
	/\*\*
	 \* Arsenals框架示例程序入口
	 \*/
	use Demo\DemoBootstrap;
	
	// 定义项目配置
	define('APP_NAME', 'Demo');
	define('BASE_PATH', realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR);
	
	// 项目入口
	require BASE_PATH . 'Demo/DemoBootstrap.php';
	$instance = new DemoBootstrap();
	$instance->startup();
	</pre>
	在项目Demo下，建立项目初始化文件DemoBootstrap.php文件。
	<pre>
	namespace Demo;
	use Arsenals\Core\Router as Route;
	
	require BASE_PATH . 'Arsenals' . DIRECTORY_SEPARATOR . 'ArsenalsBootstrap.php';
	// 自定义的初始化文件必须继承自ArsenalsBootstrap类
	class DemoBootstrap extends \Arsenals\ArsenalsBootstrap {
		// run方法为项目提供了更加方便的配置方式，可以
		// 在此文件中自定义路由以及其它一些个性化配置等
		public function run() {
			Route::map("art", '\\Demo\\controllers\\Articles@lists');
			Route::map("articles/lists", function ($input){
				return $input->get("cat");
			});
		}
	
	}
	</pre>
- **项目配置**  
	配置文件并不是必须的，如果没有在项目下建立配置文件，将会采用框架内置的配置文件对系统进行配置，自定义配置可以覆盖默认配置。
- **部署运行**  
	完成项目配置之后就可以简单的写一个控制器，然后运行程序查看结果了。  
	写一个简单的测试控制器Index控制器：
	<pre>
	namespace Demo\controllers;
	use Arsenals\Core\Abstracts\Controller;
	
	class Index extends Controller{
		public function index(){
			return "hello,world";
		}
	}
	</pre>
	

##第四章 参考文档

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
下面是默认的路由配置。
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

默认情况下访问配置文件中配置的控制其方法，一般访问方法为：控制器名称/方法名（首字母小写即可）。  
如果需要自定义路由，可以在项目入口文件中定义如下： 
<pre>
public function run() {
	//Route::map("articles/lists", '\\Demo\\controllers\\Articles@lists');
	Route::map("articles/lists", function ($input){
		return $input->get("cat");
	});
}
</pre>
如果没有自定义路由，将采用系统内置路由规则，系统对所有的控制器方法注入了$input参数，该参数为Input类的实例，方便开发。  


###钩子
Arsenals框架提供了系统运行各个阶段的钩子函数功能，使对系统的扩展成为了可能，要使用钩子功能，需要在 ```config.php``` 配置文件中配置 ```hook_enabled``` 为 ```true```。  

钩子的配置文件为config目录下的 ```hook.php``` 文件,配置规则如下：
<pre>
return array(
	// before_system为挂载点
	// 挂载点挂载的功能通过数组进行配置
	'before_system' => array(
		// 执行的为DemoHook对象的beforeSystem1方法
		'Demo\\hooks\\DemoHook@beforeSystem1',
		
		// 执行的为DemoHook的静态方法beforeSystem2
		'Demo\\hooks\\DemoHook::beforeSystem2'
	)	
);
</pre>



系统内置挂载点：
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

###字段校验规则
Arsenals框架提供了字段校验功能，开发过程中，可以方便的使用框架提供的字段校验功能对来自用户的输入信息进行校验。

要使用字段校验功能，需要使用Input类的静态方法validate方法。
<pre>
\Arsenals\Core\Input::validate($var, $type, $optionals = null)
</pre>
- ```$var``` 需要检验的字段值
- ```$type``` 校验采用的规则
- ```$optionals``` 额外的参数，可以为空

####系统内置校验规则： 
- 正则表达式(指定type为Input::REGEXP)， 第三个参数optionals为正则表达式
- 单一规则  
	int, boolean, float, validate_url, validate_email, validate_ip, string, stripped,  email, url, number_int, number_float, magic_quotes  
- 组合规则  
<table>
<thead>
	<tr><th>规则</th><th>用途</th></tr>
</thead>
<tbody>
	<tr>
		<td>required</td>
		<td>字段必须</td>
	</tr>
	<tr>
		<td>string</td>
		<td>字符串，可以指定长度（最小长度,最大长度）</td>
	</tr>
	<tr>
		<td>number, int, float</td>
		<td>数字，可以指定范围(最小值,最大值)</td>
	</tr>
	<tr>
		<td>range</td>
		<td>指定范围(最小值,最大值)</td>
	</tr>
	<tr>
		<td>len</td>
		<td>指定长度（最小长度,最大长度）</td>
	</tr>
</tbody>
</table>

注意： 多个规则之间属于偶那个|进行分隔。  
如果需要指定规则参数，使用如下规则： 规则名:参数1,参数2

如果需要使用自定义的规则也很简单，使用Input的validateRuleRegister方法，为Input类注册自定义的校验规则。
<pre>
\Arsenals\Core\Input::validateRuleRegister($rule_name, $entity_name)
</pre>
```$rule_name``` 为定义的规则名称，```$entity_name``` 为规则实现（使用系统约定的对象指定方式）。

###模板引擎
默认是采用系统内置的简单模板的，该模板使用纯PHP。  

可以通过在入口文件中定义常量 **VIEW_LAWER** 修改默认采用的模板引擎，默认值为： **Arsenals\Core\Views\SimpleView** ，采用纯PHP模板。
例如：  

```define('VIEW_LAYER', 'Arsenals\Core\Views\SimpleView');```  

系统还提供了一个基于Twig的模板引擎，不过需要手动加入Twig的类库才可以使用。加入Twig的类库之后，需要在项目的入口文件中定义Twig的Autoloader.php文件的路径常量，如下所示：  

```define('TWIG_LIB', 'Twig所在目录/Autoloader.php');```

接下来再配置VIEW_LAWER值为 **'Arsenals\Libraries\Twig\TwigView'** 即可。

####自定义模板引擎
除了使用内置模板引擎之外，开发者可以使用自定义的模板引擎，使用自定义的模板引擎也很简单，只需要实现自定义的视图解析类，自定义视图解析类实现 **Arsenals\Core\Views\View** 接口即可。  

View接口中包含两个方法， ```display($vm)```和```parse($vm)```, $vm为```Arsenals\Core\Views\ViewAndModel```类型的对象，其中保存了要显示的视图名称以及传递给视图的数据模型。

```display($vm)``` 方法中实现显示视图解析结果给浏览器。

```parse($vm)``` 方法完成视图解析，并返回解析后的视图内容。

例如：  
<pre>
namespace Demo\DemoViews;
use Arsenals\Core\Views\View;

class DemoView implements View{  
	public function display($vm){  
		echo $this->parse($vm);
	}  
	public function parse($vm){  
		// $vm->getDatas(); 传递给视图的数据数组
		// 例如： @extract($vm->getDatas());

		// $vm->getView(); 要显示的视图名称

		return "解析之后的视图字符串";
	}
}
</pre>

配置常量VIEW_LAWE为 ```Demo\DemoViews\DemoView```即可。