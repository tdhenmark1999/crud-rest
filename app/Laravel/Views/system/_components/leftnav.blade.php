<div class="be-left-sidebar">
    <div class="left-sidebar-wrapper"><a href="#" class="left-sidebar-toggle">{{env('APP_NAME',"Mentor Me Program")}}</a>
        <div class="left-sidebar-spacer">
            <div class="left-sidebar-scroll">
                <div class="left-sidebar-content">
                    <ul class="sidebar-elements">
                       
                       

                       
                        <li class="divider">Masterfile</li>
                        <li class="parent"><a href="#"><i class="icon mdi mdi-face"></i><span>Events</span></a>
                            <ul class="sub-menu">
                                <li><a href="{{route('system.article.index')}}">All records</a> </li>
                                <li><a href="{{route('system.article.create')}}">Create New</a> </li>
                            </ul>
                        </li>
                        <li class="parent"><a href="#"><i class="icon mdi mdi-face"></i><span>News</span></a>
                            <ul class="sub-menu">
                                <li><a href="{{route('system.news.index')}}">All records</a> </li>
                                <li><a href="{{route('system.news.create')}}">Create New</a> </li>
                            </ul>
                        </li>
                      
                     
                       
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>