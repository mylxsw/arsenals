#Arsenals 开发文档
**版本号： 1.0 DEV**  
**作者： 管宜尧**  
***2014/1/4 0:04:56***

##第一章 架构指南
Arsenals采用了基于MVC的架构，同时支持Service层的扩展。  
- **控制器（controller)**  
	控制器主要负责处理用户的请求，选择相应的Service层或者是模型层对用户的请求进行处理,并负责选择视图展示需要输出的内容。  
- **服务层（service）**  *可选*  
	服务层是可选的，完成系统业务逻辑的处理。  
- **模型层（model）**  
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
		<td>pdo （暂未实现）</td>
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
	<tr>
		<td>route</td>
		<td>空数组</td>
		<td>以数组的kv形式提供路由映射，key为url（支持正则）， value为控制器方法字符串标识</td>
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

Route::map方法支持任意数量参数，可以在第三个参数开始任意传递变量，该参数将会自动附加到回调函数或者控制器方法中，例如：
<pre>
Route::map('^原创音乐$', function($media, $action){
	return "这里是原创音乐:{$media} {$action}";
}, "MP3", "play");
</pre>

**小提示** ： *如果方法或者回调函数 **第一个** 参数为Input类型的对象，则可以自动注入Input对象，其它参数顺序后移一位。*

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
		<td>before_controller</td>
		<td>控制器之前</td>
	</tr>
	<tr>
		<td>after_controller</td>
		<td>控制器之后</td>
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
	<tr>
		<td>id</td>
		<td>ID校验，默认为数字</td>
	</tr>
	<tr>
		<td>in</td>
		<td>指定在给定范围内， 如in:1,2,3 取值只允许1,2,3之一</td>
	</tr>
</tbody>
</table>

注意： 多个规则之间用|进行分隔。  
如果需要指定规则参数，使用如下规则： 规则名:参数1,参数2

如果需要使用自定义的规则也很简单，使用Input的validateRuleRegister方法，为Input类注册自定义的校验规则。
<pre>
\Arsenals\Core\Input::validateRuleRegister($rule_name, $entity_name)
</pre>
```$rule_name``` 为定义的规则名称，```$entity_name``` 为规则实现（使用系统约定的对象指定方式）。

###模板引擎
默认是采用系统内置的简单模板的，该模板使用纯PHP。  
在控制器中渲染模板引擎只需要执行 ```ViewAndModel::make()``` 或者 ```VM::make()``` 方法即可获取解析之后的模板内容。

可以通过在入口文件中定义常量 **VIEW_LAWER** 修改默认采用的模板引擎，默认值为： **Arsenals\Core\Views\SimpleView** ，采用纯PHP模板。
例如：  

```define('VIEW_LAYER', 'Arsenals\Core\Views\SimpleView');```  


####内置模板引擎ArsenalsTemplates
如果需要使用模板引擎，可以采用系统内置模板引擎 ```ArsenalsTemplates``` , 采用该模板引擎后，视图代码中可以使用内置标签，标签语法类似于Java EE中的JSTL语法。

使用前需要先配置使用该模板引擎，在项目入口文件中定义常量：   
<pre>define('VIEW_LAYER', 'Arsenals\Core\Views\ArsenalsTemplates');</pre>
该模板引擎默认是使用 ```.html``` 作为模板文件扩展名，因此，所有的模板文件均为 *.html格式。   
在模板中可以使用内置标签库语法进行模板编写。   
#####标签库
- out 		
- if
- elif
- else
- include
- while
- foreach/loop
- func

例如：
模板文件index.html中：
<pre>
	&lt;html&gt;
		&lt;head&gt;
			&lt;title&gt;样例&lt;/title&gt;
		&lt;/head&gt;
		&lt;body&gt;
			&lt;div&gt;
				&lt;c:out value="$value" escape="true" default="hello" &gt;
			&lt;/div&gt;
		&lt;/body&gt;
	&lt;/html&gt;
</pre>
#####模板编译缓存
为了提高效率，模板文件在第一次运行时会编译成 ```.php``` 的缓存文件，以使得在程序运行过程中省略掉模板编译过程，提高运行效率。   
默认编译缓存在缓存目录下的views文件夹中，并且保持了模板文件的原始文件结构以及文件名称（除扩展名之外）。   
#####标签变量规范
模板引擎是基于文本解析的，因此，对标签项的配置比较严格，因此，需要按照标签变量规范进行标签内容录入。如下变量必须进行替换：
<table>
<thead>
	<tr><th>原始字符</th><th>替换字符</th></tr>
</thead>
<tbody>
	<tr>
		<td>&gt;</td>
		<td>gt</td>
	</tr>
	<tr>
		<td>&lt;</td>
		<td>lt</td>
	</tr>
	<tr>
		<td>==</td>
		<td>eq</td>
	</tr>
	<tr>
		<td>!=</td>
		<td>neq</td>
	</tr>
	<tr>
		<td>&gt;=</td>
		<td>gte</td>
	</tr>
	<tr>
		<td>&lt;=</td>
		<td>lte</td>
	</tr>
	<tr>
		<td>\</td>
		<td>.（这里指的是命名空间分隔符）</td>
	</tr>
</tbody>
</table>
例如：
<pre>
	&lt;c:func func="Demo.hello()" /&gt;
	输出为：&lt;?php echo Demo\hello(); ?&gt;

	&lt;c:if test="$a gt 5"&gt;
		${var}
	&lt;/c:if&gt;
	输出为：
		&lt;?php if($a &gt 5) { ?&gt;
		&lt;?php echo $var; ?&gt;
		&lt;?php } ?&gt;
</pre>

####第三方模板引擎
系统还提供了一个基于Twig的模板引擎，不过需要手动加入Twig的类库才可以使用。加入Twig的类库之后，需要在项目的入口文件中定义Twig的Autoloader.php文件的路径常量，如下所示：  

```define('TWIG_LIB', 'Twig所在目录/Autoloader.php');```

接下来再配置VIEW_LAWER值为 **'Arsenals\Libraries\Twig\TwigView'** 即可。

####自定义模板引擎
除了使用内置模板引擎之外，开发者可以使用自定义的模板引擎，使用自定义的模板引擎也很简单，只需要实现自定义的视图解析类，自定义视图解析类实现 **Arsenals\Core\Views\View** 接口即可。  

View接口中只包含一个方法， ```parse($vm)```, $vm为```Arsenals\Core\Views\ViewAndModel```类型的对象，其中保存了要显示的视图名称以及传递给视图的数据模型。

```parse($vm)``` 方法完成视图解析，并返回解析后的视图内容。

例如：  
<pre>
namespace Demo\DemoViews;
use Arsenals\Core\Views\View;

class DemoView implements View{  
	public function parse($vm){  
		// $vm->getDatas(); 传递给视图的数据数组
		// 例如： @extract($vm->getDatas());

		// $vm->getView(); 要显示的视图名称

		return "解析之后的视图字符串";
	}
}
</pre>

配置常量VIEW_LAWE为 ```Demo\DemoViews\DemoView```即可。

###日志系统
开发过程中要进行日志记录，可以通过使用内置的 ```\Arsenals\Core\Log``` 类进行日志记录，默认情况下，系统日志功能是关闭的。   
如果要启用日志功能，需要在项目入口文件中定义常量 ```LOG``` 为 ```true``` 。   
默认情况下，系统会使用内置的文件方式进行日志写入，你也可以通过自定义日志实现进行接管日志写入操作，系统日志实现由常量 ```LOG_IMPL``` 定义，默认值为	```Arsenals\\Core\\Logs\\FileLogImpl``` ， 采用基于文件的方式。 

要写入日志，使用一下方法：   
<pre>
$log = Registry::load('Arsenals\\Core\\Log');
$log->debug("日志内容", '日志类型');
</pre>

日志类型含有三种： info, debug, error, warning。    
如果需要获取日志内容， 使用 ```getLogs(日志级别)``` 方法。 

如果需要控制写入日志的级别，可以通过log.php配置文件进行配置：
<pre>
return array(
	'log_levels' => array('info', 'error', 'warning', 'debug') // 允许的日志级别
);
</pre>
 
####自定义日志实现
要使用自定义的日志实现，需要实现 ```Arsenals\Core\Logs``` 接口， 该接口含有两个方法：   
<pre>
public function write($level, $message);
public function getLogs($level = null);
</pre>
然后再入口文件中定义日志实现就可以了。   
<pre>define('LOG_IMPL', '你的日志实现类（包含命名空间）');</pre>
###杂项
####异常处理/错误处理
可以在项目入口文件index.php中通过定义常量 ```ERROR_HANDLER``` 和 ```EXCEPTION_HANDLER``` 使用自定义的异常处理。  
例如：
<pre>
define('ERROR_HANDLER', 'Arsenals\\Core\\_error_handler');
define('EXCEPTION_HANDLER', 'Arsenals\\Core\\_exception_handler');

function _error_handler($errno, $errstr, $errfile, $errline){
	_D("文件{$errfile}的第{$errline}行有一个错误，错误代码为{$errno}, 错误描述:{$errstr}");
}

function _exception_handler(\Exception $exception){
	_D("文件{$exception->getFile()}的第{$exception->getLine()}行抛出异常， 错误代码为 {$exception->getCode()}， 错误描述 ：{$exception->getMessage()}");
}
</pre>
####内置异常
框架实现中包含了一些可能会常用到的异常，在开发过程中可以直接使用内置异常类。  
系统内置异常统一在命名空间 ```Arsenals\Core\Exceptions``` 下，并且都继承了 ```Arsenals\Core\Exceptions\ArsenalsException``` 异常基类。   
<table>
<thead>
	<tr><th>内置异常类</th><th>用途</th></tr>
</thead>
<tbody>
	<tr>
		<td>AccessDeniedException</td>
		<td>拒绝访问异常，一般用于没有权限访问</td>
	</tr>
	<tr>
		<td>ClassNotFoundException</td>
		<td>找不到类</td>
	</tr>
	<tr>
		<td>ClassTypeException</td>
		<td>类不是合法的类型</td>
	</tr>
	<tr>
		<td>FormInvalidException</td>
		<td>表单异常，如表单校验异常</td>
	</tr>
	<tr>
		<td>FuncParamException</td>
		<td>函数，方法调用参数异常</td>
	</tr>
	<tr>
		<td>NoRecoredException</td>
		<td>没有查询到指定基类异常</td>
	</tr>
	<tr>
		<td>PageNotFoundException</td>
		<td>找不到要访问的页面异常</td>
	</tr>
	<tr>
		<td>QueryException</td>
		<td>查询异常</td>
	</tr>
	<tr>
		<td>RedefineException</td>
		<td>重复定义异常</td>
	</tr>
	<tr>
		<td>TypeErrorException</td>
		<td>错误的类型</td>
	</tr>
</tbody>
</table>

###扩展类库
####图形验证码
扩展库中包含简单验证码实现，调用方式非常简单：
<pre>
$captcha = Registry::load('\Arsenals\Libraries\Images\Captcha');
$code = $captcha->generageCode();
$captcha->createImage($code);
</pre>
注意的是，```createImage``` 方法可以接收两个参数，第一个参数为验证码字符串，第二个参数为可选，如果为NULL，则验证码直接输出到浏览器，或者可以为要保存验证码的文件名。

####SAE(新浪云计算平台)支持
要启用SAE支持，可以通过钩子挂载系统启动前期，加入SAE支持库实现。   
首先，需要在项目配置文件 ```config.php``` 中启用钩子， ```hook_enabled``` 为 ```true``` ；   
其次，在hook.php配置文件中配置系统运行前钩子实现：   
<pre>
'before_system' => array( 
		'Demo\\hooks\\DemoHook@beforeSystem'
)
</pre>
在DemoHook类中，定义载入SAE支持类库：
<pre>
public function beforeSystem(){
	$sae = new \Arsenals\Libraries\Sae\SaeInit();
	$sae->init();
}
</pre>

这样，就启用了对SAE的支持了，程序开发过程中，可以通过使用常量 ```IS_SAE``` 对是否是SAE环境进行判断。   
为了实现SAE与传统环境之间的兼容，开发过程中注意不要使用本地文件系统操作函数，而使用系统内置的函数代替：
<pre>
\Arsenals\Core\file_put_contents
\Arsenals\Core\file_get_contents
\Arsenals\Core\file_exists
\Arsenals\Core\opendir
\Arsenals\Core\readdir
\Arsenals\Core\unlink
\Arsenals\Core\closedir
\Arsenals\Core\is_file
\Arsenals\Core\move_uploaded_file
</pre>