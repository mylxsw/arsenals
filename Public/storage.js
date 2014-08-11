/**
 * Store(LocalStorage)
 */
;var store=function(){var e={},t=window,n=t.document,r="localStorage",i="globalStorage",s;e.set=function(e,t){},e.get=function(e){},e.remove=function(e){},e.clear=function(){};if(r in t&&t[r])s=t[r],e.set=function(e,t){s.setItem(e,t)},e.get=function(e){return s.getItem(e)},e.remove=function(e){s.removeItem(e)},e.clear=function(){s.clear()};else if(i in t&&t[i])s=t[i][t.location.hostname],e.set=function(e,t){s[e]=t},e.get=function(e){return s[e]&&s[e].value},e.remove=function(e){delete s[e]},e.clear=function(){for(var e in s)delete s[e]};else if(n.documentElement.addBehavior){function o(){return s?s:(s=n.body.appendChild(n.createElement("div")),s.style.display="none",s.addBehavior("#default#userData"),s.load(r),s)}e.set=function(e,t){var n=o();n.setAttribute(e,t),n.save(r)},e.get=function(e){var t=o();return t.getAttribute(e)},e.remove=function(e){var t=o();t.removeAttribute(e),t.save(r)},e.clear=function(){var e=o(),t=e.XMLDocument.documentElement.attributes;e.load(r);for(var n=0,i;i=t[n];n++)e.removeAttribute(i.name);e.save(r)}}return e}()

/**
 * 对LocalStorage的封装
 */
;
var LOCAL = {
    isExist: function(key){
		return !!store.get(key);
	},
    set: function(key, value, is_obj){
        is_obj = is_obj || false;
        if(is_obj){
        	value = JSON.stringify(value);
        }
        
        store.set(key, value);
    },
    get: function(key, is_obj){
        is_obj = is_obj || false;
        if(this.isExist(key)){
           return is_obj ? JSON.parse(store.get(key)) : store.get(key);
        }
		return false;
    },
    remove: function(key){
        if(this.isExist(key)){
    		store.remove(key);
        }
    },
    clear: function(){
     	store.clear();
    }
};