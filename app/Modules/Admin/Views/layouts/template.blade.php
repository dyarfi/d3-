<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <title>{{ isset($title) ? $title : '' }} {{ isset($title) ? ' | '. $admin_app : $admin_app }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="description" content="overview &amp; stats" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <link rel="stylesheet" href="{{ asset('themes/ace-admin/font-awesome/4.2.0/css/font-awesome.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('themes/ace-admin/fonts/fonts.googleapis.com.css') }}" />
    <?php /* LARAVEL Mix see webpack.mix.js for recompile the files */ ?>
    <link rel="stylesheet" href="{{ mix('themes/ace-admin/css/d3all.css') }}">
    <!--[if lte IE 9]>
      <link rel="stylesheet" href="{{ asset('themes/ace-admin/css/css/ace-part2.min.css') }}" class="ace-main-stylesheet" />
    <![endif]-->
    <!--[if lte IE 9]>
      <link rel="stylesheet" href="{{ asset('themes/ace-admin/css/ace-ie.min.css') }}" />
    <![endif]-->
@if(isset($styles))
  @foreach ($styles as $style => $css) {!! Html::style($css, ['rel'=>'stylesheet']) !!} @endforeach
@endif
    <!-- inline styles related to this page -->
    <script>var base_URL = '{{ url('/') }}/'; var base_ADM = '{{ url(config("setting.admin_url")) }}/';</script>
    <!-- ace settings handler -->
    <script src="{{ asset('themes/ace-admin/js/ace-extra.min.js') }}"></script>
    <!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->
    <!--[if lte IE 8]>
    <script src="{{ asset('themes/ace-admin/js/html5shiv.min.js') }}"></script>
    <script src="{{ asset('themes/ace-admin/assets/js/respond.min.js') }}"></script>
    <![endif]-->
  </head>
  <body class="no-skin">
    <div id="navbar" class="navbar navbar-default">
      <script type="text/javascript">
        try{ace.settings.check('navbar' , 'fixed')}catch(e){}
      </script>
      <!-- <div class="navbar-container" id="navbar-container"> -->
      <div class="navbar" id="navbar-container">
        <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
          <span class="sr-only">Toggle sidebar</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <div class="navbar-header pull-left">
          <a href="{{ URL::to($admin_url) }}" class="navbar-brand">
            <small>
              <i class="fa fa-leaf"></i>
              {{ $admin_app }}
            </small>
          </a>
        </div>
        @include('Admin::partials.property')
      </div><!-- /.navbar-container -->
    </div>
    <div class="main-container" id="main-container">
      <script type="text/javascript">
        try{ace.settings.check('main-container' , 'fixed')}catch(e){}
      </script>
      @include('Admin::partials.navigation')
      <div class="main-content">
        <div class="main-content-inner">
          <div class="breadcrumbs hidden" id="breadcrumbs">
            <script type="text/javascript">
              try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
            </script>
            <ul class="breadcrumb">
                <li><i class="ace-icon fa fa-home home-icon"></i><a href="#">Home</a></li>
                <li><a href="#">More Pages</a></li>
                <li class="active">User Profile</li>
            </ul><!-- /.breadcrumb -->
            <div class="nav-search" id="nav-search">
              <form class="form-search">
                <span class="input-icon">
                  <input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
                  <i class="ace-icon fa fa-search nav-search-icon"></i>
                </span>
              </form>
            </div><!-- /.nav-search -->
          </div>
          @if (isset($controller) && isset($action) && $controller != 'BaseAdmin')
            <div class="breadcrumbs">
              <ul class="breadcrumb">
                <li>
                  <i class="ace-icon fa fa-home home-icon"></i>
                  <a href="{{ route('admin.dashboard') }}">Home</a>
                </li>
                <li class="active">
                  <a href="{{ route('admin.'.strtolower(@$controller).'.index') }}">{{ ucfirst(@$controller) }}</a>
                </li>
                  @if(@$action)
                  <li class="">
                    {{ ucfirst(@$action) }}
                  </li>
                  @endif
              </ul><!-- /.breadcrumb -->
            </div>
          @endif
          <div class="page-content">
            @if(Sentinel::check())
            <div class="ace-settings-container hide" id="ace-settings-container">
              <div class="btn btn-app btn-xs btn-warning ace-settings-btn" id="ace-settings-btn">
                <i class="ace-icon fa fa-cog bigger-130"></i>
              </div>
              <div class="ace-settings-box clearfix" id="ace-settings-box">
                <div class="pull-left width-50">
                  <div class="ace-settings-item">
                    <div class="pull-left">
                      <select id="skin-colorpicker" class="hide">
                      <?php
                      if (config('setting.attributes')) {
                        foreach (config('setting.attributes') as $setting => $attribute) {
                          if ($setting == 'skins') {
                            $d=1;
                            foreach ($attribute as $attr => $val) {
                                if (@app('App\Modules\User\Model\User')->find(Auth::getUser()->id)->attributes->skins && app('App\Modules\User\Model\User')->find(Auth::getUser()->id)->attributes->skins == $attr) { ?>
                                  <option data-skin="no-skin" value="{{$attr}}" checked="checked" data-skin="no-skin">{{$attr}}</option>
                              <?php } else { ?>
                                  <option data-skin="skin-{{$d}}" value="{{$attr}}">{{$attr}}</option>
                              <?php }
                              $d++;
                            }
                          }
                        }
                      }
                      ?>
                      </select>
                    </div>
                    <span>&nbsp; Choose Skin</span>
                  </div>
                  <div class="ace-settings-item">
                    <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-navbar" />
                    <label class="lbl" for="ace-settings-navbar"> Fixed Navbar</label>
                  </div>
                  <div class="ace-settings-item">
                    <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-sidebar" />
                    <label class="lbl" for="ace-settings-sidebar"> Fixed Sidebar</label>
                  </div>
                  <div class="ace-settings-item">
                    <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-breadcrumbs" />
                    <label class="lbl" for="ace-settings-breadcrumbs"> Fixed Breadcrumbs</label>
                  </div>
                  <div class="ace-settings-item">
                    <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-rtl" />
                    <label class="lbl" for="ace-settings-rtl"> Right To Left (rtl)</label>
                  </div>
                  <div class="ace-settings-item">
                    <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-add-container" />
                    <label class="lbl" for="ace-settings-add-container">
                      Inside
                      <b>.container</b>
                    </label>
                  </div>
                </div><!-- /.pull-left -->
                <div class="pull-left width-50">
                  <div class="ace-settings-item">
                    <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-hover" />
                    <label class="lbl" for="ace-settings-hover"> Submenu on Hover</label>
                  </div>
                  <div class="ace-settings-item">
                    <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-compact" />
                    <label class="lbl" for="ace-settings-compact"> Compact Sidebar</label>
                  </div>
                  <div class="ace-settings-item">
                    <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-highlight" />
                    <label class="lbl" for="ace-settings-highlight"> Alt. Active Item</label>
                  </div>
                </div><!-- /.pull-left -->
              </div><!-- /.ace-settings-box -->
            </div><!-- /.ace-settings-container -->
            @endif

            <!--div class="space-16"></div-->

            <div class="row">
              <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                
                <!--div class="alert alert-block alert-success">
                  <button type="button" class="close" data-dismiss="alert">
                    <i class="ace-icon fa fa-times"></i>
                  </button>
                  <i class="ace-icon fa fa-check green"></i>
                  Welcome to
                  <strong class="green">
                    Ace
                    <small>(v1.3.3)</small>
                  </strong>,
  легкий, много-функциональный и простой в использовании шаблон для админки на bootstrap 3.3. Загрузить исходники с <a href="https://github.com/bopoda/ace">github</a> (with minified ace js files).
                </div-->

                @include('Admin::partials.notification')
                @yield('body')
                <!-- PAGE CONTENT ENDS -->
              </div><!-- /.col -->
            </div><!-- /.row -->
          </div><!-- /.page-content -->
        </div>
      </div><!-- /.main-content -->
      <div class="footer">
        <div class="footer-inner">
          <div class="footer-content">
            <span class="bigger-120">
              <span class="blue bolder">
                  {{ @app('App\Modules\User\Model\Setting')->slug('site-name')->value }}
              </span> &copy; 2013-{{ date('Y') }}
            </span>
            &nbsp; &nbsp;
            <span class="action-buttons">
                @foreach (@app('App\Modules\User\Model\Setting')->group('socmed') as $socmed)
                <a href="{{$socmed->value}}">
                  <i class="ace-icon fa fa-{{str_replace('socmed-','',$socmed->slug)}} light-blue bigger-150"></i>
                </a>
                @endforeach
            </span>
          </div>
        </div>
      </div>
      <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse"><i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i></a>
    </div><!-- /.main-container -->
    <!-- basic scripts -->
    <!--[if !IE]> -->
    <script src="{{ asset('themes/ace-admin/js/jquery.2.1.1.min.js') }}"></script>
    <!-- <![endif]-->
    <!--[if IE]>
      <script src="{{ asset('themes/ace-admin/js/jquery.1.11.1.min.js') }}"></script>
    <![endif]-->
    <!--[if !IE]> -->
    <script type="text/javascript">
      window.jQuery || document.write("<script src='{{ asset('themes/ace-admin/js/jquery.min.js') }}>"+"<"+"/script>");
    </script>
    <!-- <![endif]-->
    <!--[if IE]>
    <script type="text/javascript">
     window.jQuery || document.write("<script src='{{ asset('themes/ace-admin/js/jquery1x.min.js') }}>"+"<"+"/script>");
    </script>
    <![endif]-->
    <script type="text/javascript">
      if('ontouchstart' in document.documentElement) document.write("<script src='{{ asset('themes/ace-admin/js/jquery.mobile.custom.min.js') }}'>"+"<"+"/script>");
    </script>    
    <?php /* LARAVEL Mix see webpack.mix.js for recompile the files */ ?>    
    <script src="{{ mix('themes/ace-admin/js/d3all.js') }}"></script>
    <!--[if lte IE 8]><script src="{{ asset('themes/ace-admin/js/excanvas.min.js') }}"></script><![endif]-->
    <script src="{{ asset('themes/ace-admin/js/dropzone.min.js') }}"></script>
@if(isset($scripts)) @foreach($scripts as $script => $js) {!! Html::script($js, ['rel'=>$script]) !!} @endforeach @endif
@if(isset($inlines))
    <!-- page specific plugin scripts and styles -->
    @foreach($inlines as $inline => $line)
        @if($inline == 'script')<script type="text/javascript">{!! $line !!}</script>
        @elseif($inline == 'style')<style type="text/css">{!! $line !!}</style>
        @endif
    @endforeach
@endif    
    <!-- inline scripts related to this page -->
    <script type="text/javascript">
      jQuery(function($) {

          // Add active class to current page menu
          $('.submenu').find('.active').parents('li').addClass('active').find('b').removeClass('arrow fa fa-angle-down');

          /********************************/
          //add tooltip for small view action buttons in dropdown menu
          $('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});

          //tooltip placement on right or left
          function tooltip_placement(context, source) {
            var $source = $(source);
            var $parent = $source.closest('table')
            if ($parent.size > 0) {
              var off1 = $parent.offset();
              var w1 = $parent.width();

              var off2 = $source.offset();
              //var w2 = $source.width();

              if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
            }
            return 'left';
          }


        // TABLE DATA ---------------------------------------

        $('[data-rel=tooltip]').tooltip();

        if ($('.easy-pie-chart.percentage').size() > 0 ) {

            $('.easy-pie-chart.percentage').each(function(){
              var $box = $(this).closest('.infobox');
              var barColor = $(this).data('color') || (!$box.hasClass('infobox-dark') ? $box.css('color') : 'rgba(255,255,255,0.95)');
              var trackColor = barColor == 'rgba(255,255,255,0.95)' ? 'rgba(255,255,255,0.25)' : '#E2E2E2';
              var size = parseInt($(this).data('size')) || 50;
              $(this).easyPieChart({
                barColor: barColor,
                trackColor: trackColor,
                scaleColor: false,
                lineCap: 'butt',
                lineWidth: parseInt(size/10),
                animate: /msie\s*(8|7|6)/.test(navigator.userAgent.toLowerCase()) ? false : 1000,
                size: size
              });
            })

            $('.sparkline').each(function(){
              var $box = $(this).closest('.infobox');
              var barColor = !$box.hasClass('infobox-dark') ? $box.css('color') : '#FFF';
              $(this).sparkline('html',
                       {
                        tagValuesAttribute:'data-values',
                        type: 'bar',
                        barColor: barColor ,
                        chartRangeMin:$(this).data('min') || 0
                       });
            });


            //flot chart resize plugin, somehow manipulates default browser resize event to optimize it!
            //but sometimes it brings up errors with normal resize event handlers
            //$.resize.throttleWindow = false;

            var placeholder = $('#piechart-placeholder').css({'width':'90%' , 'min-height':'150px'});
            var data = [
            { label: "social networks",  data: 38.7, color: "#68BC31"},
            { label: "search engines",  data: 24.5, color: "#2091CF"},
            { label: "ad campaigns",  data: 8.2, color: "#AF4E96"},
            { label: "direct traffic",  data: 18.6, color: "#DA5430"},
            { label: "other",  data: 10, color: "#FEE074"}
            ]
            function drawPieChart(placeholder, data, position) {
              $.plot(placeholder, data, {
              series: {
                pie: {
                  show: true,
                  tilt:0.8,
                  highlight: {
                    opacity: 0.25
                  },
                  stroke: {
                    color: '#fff',
                    width: 2
                  },
                  startAngle: 2
                }
              },
              legend: {
                show: true,
                position: position || "ne",
                labelBoxBorderColor: null,
                margin:[-30,15]
              }
              ,
              grid: {
                hoverable: true,
                clickable: true
              }
             })
           }
           drawPieChart(placeholder, data);

           /**
           we saved the drawing function and the data to redraw with different position later when switching to RTL mode dynamically
           so that's not needed actually.
           */
           placeholder.data('chart', data);
           placeholder.data('draw', drawPieChart);


            //pie chart tooltip example
            var $tooltip = $("<div class='tooltip top in'><div class='tooltip-inner'></div></div>").hide().appendTo('body');
            var previousPoint = null;

            placeholder.on('plothover', function (event, pos, item) {
            if(item) {
              if (previousPoint != item.seriesIndex) {
                previousPoint = item.seriesIndex;
                var tip = item.series['label'] + " : " + item.series['percent']+'%';
                $tooltip.show().children(0).text(tip);
              }
              $tooltip.css({top:pos.pageY + 10, left:pos.pageX + 10});
            } else {
              $tooltip.hide();
              previousPoint = null;
            }

           });

            /////////////////////////////////////
            $(document).one('ajaxloadstart.page', function(e) {
              $tooltip.remove();
            });


            var d1 = [];
            for (var i = 0; i < Math.PI * 2; i += 0.5) {
              d1.push([i, Math.sin(i)]);
            }

            var d2 = [];
            for (var i = 0; i < Math.PI * 2; i += 0.5) {
              d2.push([i, Math.cos(i)]);
            }

            var d3 = [];
            for (var i = 0; i < Math.PI * 2; i += 0.2) {
              d3.push([i, Math.tan(i)]);
            }


            var sales_charts = $('#sales-charts').css({'width':'100%' , 'height':'220px'});
            $.plot("#sales-charts", [
              { label: "Domains", data: d1 },
              { label: "Hosting", data: d2 },
              { label: "Services", data: d3 }
            ], {
              hoverable: true,
              shadowSize: 0,
              series: {
                lines: { show: true },
                points: { show: true }
              },
              xaxis: {
                tickLength: 0
              },
              yaxis: {
                ticks: 10,
                min: -2,
                max: 2,
                tickDecimals: 3
              },
              grid: {
                backgroundColor: { colors: [ "#fff", "#fff" ] },
                borderWidth: 1,
                borderColor:'#555'
              }
            });

        }


        $('#recent-box [data-rel="tooltip"]').tooltip({placement: tooltip_placement});
        function tooltip_placement(context, source) {
          var $source = $(source);
          var $parent = $source.closest('.tab-content')
          var off1 = $parent.offset();
          var w1 = $parent.width();

          var off2 = $source.offset();
          //var w2 = $source.width();
          if ($parent.size() > 0) {
            if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
          }
          //return 'left';
          return 'right';
        }


        $('.dialogs,.comments').ace_scroll({
          size: 300
          });


        //Android's default browser somehow is confused when tapping on label which will lead to dragging the task
        //so disable dragging when clicking on label
        var agent = navigator.userAgent.toLowerCase();
        if("ontouchstart" in document && /applewebkit/.test(agent) && /android/.test(agent))
          $('#tasks').on('touchstart', function(e){
          var li = $(e.target).closest('#tasks li');
          if(li.length == 0)return;
          var label = li.find('label.inline').get(0);
          if(label == e.target || $.contains(label, e.target)) e.stopImmediatePropagation() ;
        });

        $('#tasks').sortable({
          opacity:0.8,
          revert:true,
          forceHelperSize:true,
          placeholder: 'draggable-placeholder',
          forcePlaceholderSize:true,
          tolerance:'pointer',
          stop: function( event, ui ) {
            //just for Chrome!!!! so that dropdowns on items don't appear below other items after being moved
            $(ui.item).css('z-index', 'auto');
          }
          }
        );
        $('#tasks').disableSelection();
        $('#tasks input:checkbox').removeAttr('checked').on('click', function(){
          if(this.checked) $(this).closest('li').addClass('selected');
          else $(this).closest('li').removeClass('selected');
        });


        //show the dropdowns on top or bottom depending on window height and menu position
        $('#task-tab .dropdown-hover').on('mouseenter', function(e) {
          var offset = $(this).offset();

          var $w = $(window)
          if (offset.top > $w.scrollTop() + $w.innerHeight() - 100)
            $(this).addClass('dropup');
          else $(this).removeClass('dropup');
        });

///////////////////

        //typeahead.js
        //example taken from plugin's page at: https://twitter.github.io/typeahead.js/examples/
        var substringMatcher = function(strs) {
          return function findMatches(q, cb) {
            var matches, substringRegex;

            // an array that will be populated with substring matches
            matches = [];

            // regex used to determine if a string contains the substring `q`
            substrRegex = new RegExp(q, 'i');

            // iterate through the pool of strings and for any string that
            // contains the substring `q`, add it to the `matches` array
            $.each(strs, function(i, str) {
              if (substrRegex.test(str)) {
                // the typeahead jQuery plugin expects suggestions to a
                // JavaScript object, refer to typeahead docs for more info
                matches.push({ value: str });
              }
            });

            cb(matches);
          }
         }
        /*
         $('input.typeahead').typeahead({
          hint: true,
          highlight: true,
          minLength: 1
         }, {
          name: 'types',
          displayKey: 'value',
          debug:true,
          //source: substringMatcher(ace.vars['US_STATES'])
          source:substringMatcher(["text","textarea","option","radio"]),
         }).on('change', function () {
            //if($(this).val() == 'textarea') {
            //$('input#value').val();
            //}
        });
        */
        ///////////////


        $('.btn-list').on('click',function(e) {
          var listing = $(this).parent().find('.table-head');
          e.preventDefault();

          var l = $('#dynamic-table th').size() - 1;
          var html = '';
          $('#dynamic-table th').each(function(index) {
            if (index < l && index != 0) {
              html += '<li><a href="javascript:;">'+$( this ).text()+'</a></li>';
            }
          });

          listing.html(html);

        });

        $('#dynamic-table').on('ready', function(e){
            var columnNumber, rowNumber, headerText;
            columnNumber = $(e.target).index() + 1;
            rowNumber = $(e.target).parent().index() + 1;
            headerText = $('th:nth-child(' + columnNumber + ')').text();
            $('.columns').html(columnNumber);
            $('.rows').html(rowNumber);
            $('.headers').html(headerText);
        });

    $('.setting a[data-toggle="tab"]').on('show.bs.tab', function (e) {
      //e.target // newly activated tab
      //e.relatedTarget // previous active tab
      var url = location.origin + location.pathname + '#' + e.target.rel;
      location.href = url;
      //e.target.rel
    })

    $(document).one('ajaxloadstart.page', function(e) {
        $('#colorbox, #cboxOverlay').remove();
    });

})
</script>

@stack('scripts')

</body>
</html>
