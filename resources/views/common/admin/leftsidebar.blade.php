<section class="side-nav-admin">
    <div class="logo m-3 text-center">
        <span>
            <img src='{{ asset('images/goal.png') }}' width='200' height="171">
        </span>
    </div>
    <nav>
        <ul>
            <li class="active">
                <a href="#">
                    <span><i class="material-icons"></i></span>
                    <span style="color:#900; font-weight:bold; font-size:16px;">ADMINISTRATOR MENU</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <span><i class="fas fa-tachometer-alt"></i></span>
                    <span>MEMBERS MENU</span>
                </a>
                <ul>
                    <li><a href="#"><i class="fa fa-ellipsis-h"></i> Dashboard</a></li>
                    <li><a href="#"><i class="fa fa-ellipsis-h"></i>View/Edit Account Details</a></li> 
                </ul>
            </li>
            <li>
                <a href="#">
                    <span><i class="fa fa-sitemap"></i></span>
                    <span>MEMBERSHIP CODES</span>
                </a>
                <ul>
                    <li><a href="#"><i class="fa fa-ellipsis-h"></i> ENTRY CODES</a></li>
                </ul>
            </li>
            <li>
                <a href="#">
                    <span><i class="fa fa-bar-chart"></i></span>
                    <span>PAIRING FLAG</span>
                </a>
                <ul>
                    <li><a href="#"><i class="fa fa-ellipsis-h"></i> VIEW PAIR FLAG</a></li>
                </ul>
            </li>
            <li>
                <a href="#">
                    <span><i class="fa fa-envelope"></i></span>
                    <span>MEMBERS ENCASHMENT</span>
                </a>
                <ul>
                    <li><a href="#"><i class="fa fa-ellipsis-h"></i>All Encashment Requests</a></li>
                </ul>
            </li>
            <li>
                <a href="#">
                    <span><i class="fa fa-shopping-bag"></i></span>
                    <span>Products</span>
                </a>
                <ul>
                    <li><a href="#"><i class="fa fa-ellipsis-h"></i> Recent Products</a></li>
                    <li><a href="#"><i class="fa fa-ellipsis-h"></i> PRODUCT CODES</a></li>
                    <li><a href="#"><i class="fa fa-ellipsis-h"></i> Product Re-purchase Summary</a></li>

                </ul> 
            </li>
            <li>
                <a href="#">
                    <span><i class="fas fa-wallet"></i></span>
                    <span>ADMIN MENU</span>
                </a>
                <ul>
                    <li><a href="#"><i class="fa fa-ellipsis-h"></i> CONTROL PANEL</a></li>
                    <li><a href="#"><i class="fa fa-ellipsis-h"></i> WAITING LIST</a></li>
                    <li><a href="#"><i class="fa fa-ellipsis-h"></i> PROCESS WAITINGS</a></li>
                    <li><a href="#"><i class="fa fa-ellipsis-h"></i> Members Visitor</a></li>
                    <li><a href="#"><i class="fa fa-ellipsis-h"></i> Change Members Username</a></li>
                    <li><a href="#"><i class="fa fa-ellipsis-h"></i> Change Password</a></li>
                    <li><a href="#" onclick="event.preventDefault();
                                               document.getElementById('logout-form').submit();"><i class="fa fa-ellipsis-h"></i> Logout</a>
                
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form></li>

                </ul>  
            </li>
        </ul>
    </nav>
</section>