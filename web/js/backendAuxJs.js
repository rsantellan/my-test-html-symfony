mdNewsFeedBackendManager = function(options){
	this._initialize();

}

mdNewsFeedBackendManager.instance = null;

mdNewsFeedBackendManager.getInstance = function (){
	if(mdNewsFeedBackendManager.instance == null)
		mdNewsFeedBackendManager.instance = new mdNewsFeedBackendManager();
	return mdNewsFeedBackendManager.instance;
}

mdNewsFeedBackendManager.prototype = {
    _initialize: function(){
        
    }
}
    
    
