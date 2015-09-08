<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <title>管理中心</title>
        <link rel="stylesheet" href="{{ URL::to('css/jquery-ui/themes/blitzer/jquery-ui.min.css') }}">
        <link rel="stylesheet" href="{{ URL::to('css/jasny-bootstrap.css') }}">
        <link rel="stylesheet" href="{{ URL::to('css/jasny-responsive.css') }}">
        <link rel="stylesheet" href="{{ URL::to('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ URL::to('css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ URL::to('css/materials.min.css') }}">
        <link rel="stylesheet" href="{{ URL::to('css/mall.min.css') }}">
        <link rel="stylesheet" href="{{ URL::to('css/datetimepicker/bootstrap-datetimepicker.min.css') }}">
        <!--[if lt IE 9]>
        <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <link rel="shortcut icon" type="image/png" href="{{ URL::to('img/favicon.png') }}"/>
        @section('head')
        @show
    </head>
    <body>
        <header id="header">
            <div class="navbar navbar-default navbar-fixed-top">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a href="#" class="navbar-brand sidebar-toggle hidden-xs">
                            <span class="glyphicon glyphicon-menu-hamburger"></span>
                        </a>
                        <a href="{{ URL::to('admin') }}" class="navbar-brand visible-xs">管理中心</a>
                    </div>
                    <div class="navbar-collapse collapse">
                    
                        {{ \App\Helpers\RHelper::printMenu(config('menu'), 'nav navbar-nav hidden-lg hidden-md hidden-sm') }}
                        <ul class="nav navbar-nav navbar-right">
                            <li><a class="btn btn-link hidden-xs" href="{{ URL::to('logout') }}" title="Lang::get('menus.logout')">{{ Lang::get('menus.logout') }} <i class="glyphicon glyphicon-log-out"></i></a></li>
                            <li><a class="visible-xs" href="{{ URL::to('logout') }}" title="Lang::get('menus.logout')">{{ Lang::get('menus.logout') }}</a></li>
                        </ul>
                    </div><!--/.nav-collapse -->

                </div>
            </div>
        </header>

        <div id="main">
            <div class="container-fluid">
                <div id="sidebar-wrapper">
                    <div id="sidebar" class="shadow-depth-1">
                        <div id="sidebar-title">
                            <a href="{{ URL::to('admin') }}" class="redooor-nav-logo">管理中心</a>
                        </div>
                        {{ \App\Helpers\RHelper::printMenu(config('menu'), 'nav nav-sidebar') }}
                    </div>
                    <div id="sidebar-overlay" class="sidebar-toggle"></div>
                    <div class="main-content">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div><!--End main-->

        <div id="confirm-modal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">{{ Lang::get('messages.confirm_delete') }}</h4>
                    </div>
                    <div class="modal-body">
                        <p>{{ Lang::get('messages.are_you_sure_you_want_to_delete') }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{ Lang::get('buttons.delete_no') }}</button>
                        <a href="#" id="confirm-delete" class="btn btn-danger">{{ Lang::get('buttons.delete_yes') }}</a>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <script src="{{ URL::to('js/jquery/jquery.min.js') }}"></script>
        <script src="{{ URL::to('js/moment/moment.min.js') }}"></script>
        <script src="{{ URL::to('js/jquery-ui/jquery-ui.min.js') }}"></script>
        <script src="{{ URL::to('js/bootstrap.min.js') }}"></script>
        <script src="{{ URL::to('js/datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>
        <script src="{{ URL::to('js/mall.min.js') }}"></script>
        <script>
            !function ($) {
                $(function(){
                    $(document).on('click', '.btn-confirm', function(e) {
                        e.preventDefault();
                        $delete_url = $(this).attr('href');
                        $('#confirm-delete').attr('href', $delete_url);
                        $('#confirm-modal').modal('show');
                    });
                    $(document).on('click', '.sidebar-toggle', function(e) {
                        e.preventDefault();
                        if ($('#sidebar-wrapper').hasClass('active')) {
                            $('#sidebar-wrapper').removeClass('active');
                        } else {
                            $('#sidebar-wrapper').addClass('active');
                        }
                    });
                })
            }(window.jQuery);
        </script>

        @section('footer')
        @show
    </body>
</html>
