<section class="side-nav-admin  mb-2">
    <div class="logo m-3 text-center">
        <span>
            <img src='{{ asset('images/goal.png') }}' width='170'>
        </span>
    </div>
    <nav>
        <ul>
            <li class="active">
                <a href="#">
                    <span><i class="material-icons"></i></span>
                    <span style="color:#900; font-weight:bold; font-size:13px;">ADMINISTRATOR MENU</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.member.index') }}">
                    <span><i class="fas fa-address-book"></i></span>
                    <span>MEMBERS MENU</span>
                </a>
                <ul>
                    <li><a href="{{ route('admin.member.index') }}"><i class="fa fa-ellipsis-h"></i> Member Lists</a></li>
                    <li><a href="{{ route('admin.transactions.index') }}"><i class="fa fa-ellipsis-h"></i> Transactions</a></li>
                    <li><a href="{{ route('admin.transactions.bonus') }}"><i class="fa fa-ellipsis-h"></i> Transaction Bonuses</a></li>
                    <li><a href="{{ route('admin.encashment.index') }}"><i class="fa fa-ellipsis-h"></i> Encashment Requests</a></li>
                    <li><a href="{{ route('admin.memberusername.index') }}"><i class="fa fa-ellipsis-h"></i> Change Username</a></li>
                </ul>
            </li>
            <li>
                <a href="{{ route('admin.entrycodes.index') }}">
                    <span><i class="fa fa-folder-open"></i></span>
                    <span>Registration Codes</span>
                </a>
                <ul>
                    <li><a href="{{ route('admin.entrycodes.index') }}"><i class="fa fa-ellipsis-h"></i> Available Entry Codes</a></li>
                    <li><a href="{{ route('admin.entrycodes.used') }}"><i class="fa fa-ellipsis-h"></i> Used Entry Codes</a></li>
                    <li><a href="{{ route('admin.entrycodes.create') }}"><i class="fa fa-ellipsis-h"></i> Create Codes</a></li>

                </ul> 
            </li>
            <li>
                <a href="{{ route('admin.products.index') }}">
                    <span><i class="fa fa-shopping-cart"></i></span>
                    <span>Products</span>
                </a>
                <ul>
                    <li><a href="{{ route('admin.products.index') }}"><i class="fa fa-ellipsis-h"></i> Product Lists</a></li>
                    <li><a href="{{ route('admin.products.create') }}"><i class="fa fa-ellipsis-h"></i> Create Product</a></li>

                </ul> 
            </li>
            <li>
                <a href="{{ route('admin.course.index') }}">
                    <span><i class="fa fa-star"></i></span>
                    <span>Courses</span>
                </a>
                <ul>
                    <li><a href="{{ route('admin.course.index') }}"><i class="fa fa-ellipsis-h"></i> Courses Lists</a></li>
                    <li><a href="{{ route('admin.course.create') }}"><i class="fa fa-ellipsis-h"></i> Create Course</a></li>

                </ul> 
            </li>
            <li>
                <a href="{{ route('admin.controlpanel.index') }}">
                    <span><i class="fas fa-cogs"></i></span>
                    <span>ADMIN MENU</span>
                </a>
                <ul>
                    <li><a href="{{ route('admin.controlpanel.index') }}"><i class="fa fa-ellipsis-h"></i> Control Panel</a></li>
                    <li><a href="{{ route('admin.member.visit') }}"><i class="fa fa-ellipsis-h"></i> Access Log</a></li>
                    <li><a href="{{ route('admin.changepassword.index') }}"><i class="fa fa-ellipsis-h"></i> Change Password</a></li>
                    <li><a href="#" onclick="event.preventDefault();
                                               document.getElementById('logout-form').submit();"><i class="fa fa-ellipsis-h"></i> Logout</a>

                </ul>  
            </li>
        </ul>
    </nav>
</section>