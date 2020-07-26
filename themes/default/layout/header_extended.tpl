	<noscript>
		<div class="alert alert-danger">{LANG.nojs}</div>
	</noscript>
    <div class="body-bg">
	<div class="wraper">
		<header>
			<div class="container">
				<div id="header" class="row">
				    <div class="logo col-xs-24 col-sm-24 col-md-8">
                        <!-- BEGIN: image -->
						
                        <a title="{SITE_NAME}" href="{THEME_SITE_HREF}"><img src="{LOGO_SRC}" width="{LOGO_WIDTH}" height="{LOGO_HEIGHT}" alt="{SITE_NAME}" /></a>
                        <!-- END: image -->
 
    
                      
                    </div>
                    <div class="col-xs-24 col-sm-24 col-md-16">
                    [HEAD_RIGHT]
                    </div>
				</div>
			</div>
		</header>
		<nav class="second-nav" id="menusite">
			<div class="container">
				<div class="row">
                    <div class="bg box-shadow">
					[MENU_SITE]
                    </div>
				</div>
			</div>
		</nav>
        <nav class="header-nav">
            <div class="container">
                <div class="personalArea">
                [PERSONALAREA]
                </div>
                <div class="social-icons">
                [SOCIAL_ICONS]
                </div>
                <div class="contactDefault">
                [CONTACT_DEFAULT]
                </div>
                <div id="tip" data-content="">
                    <div class="bg"></div>
                </div>
            </div>
        </nav>
		<section>
			<div class="container" id="body">
                <nav class="third-nav">
    				<div class="row">
                        <div class="bg">
                        <div class="clearfix">
                            <div class="col-xs-24 col-sm-18 col-md-18">
                                <!-- BEGIN: breadcrumbs -->
                                <div class="breadcrumbs-wrap">
                                	<div class="display">
                                		<a class="show-subs-breadcrumbs hidden" href="#" onclick="showSubBreadcrumbs(this, event);"><em class="fa fa-lg fa-angle-right"></em></a>
		                                <ul class="breadcrumbs list-none"></ul>
									</div>
									<ul class="subs-breadcrumbs"></ul>
	                                <ul class="temp-breadcrumbs hidden">
	                                    <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="{THEME_SITE_HREF}" itemprop="url" title="{LANG.Home}"><span itemprop="title">{LANG.Home}</span></a></li>
	                                    <!-- BEGIN: loop --><li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="{BREADCRUMBS.link}" itemprop="url" title="{BREADCRUMBS.title}"><span class="txt" itemprop="title">{BREADCRUMBS.title}</span></a></li><!-- END: loop -->
	                                </ul>
								</div>
                                <!-- END: breadcrumbs -->
                                <!-- BEGIN: currenttime --><span class="current-time">{NV_CURRENTTIME}</span><!-- END: currenttime -->
                            </div>
                            <div class="headerSearch col-xs-24 col-sm-6 col-md-6">
                                <div class="input-group">
                                    <input type="text" class="form-control" maxlength="{NV_MAX_SEARCH_LENGTH}" placeholder="{LANG.search}..."><span class="input-group-btn"><button type="button" class="btn btn-info" data-url="{THEME_SEARCH_URL}" data-minlength="{NV_MIN_SEARCH_LENGTH}" data-click="y"><em class="fa fa-search fa-lg"></em></button></span>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </nav>
                [THEME_ERROR_INFO]
