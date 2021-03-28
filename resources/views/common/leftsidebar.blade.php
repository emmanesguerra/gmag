<section class="side-nav">
    <div class="logo m-3">
        <span>
            <img src='{{ asset('images/goal.png') }}' width='150' height="120">
        </span>
    </div>
    <nav>
        <ul>
            <li class="active">
                <a href="#">
                    <span><i class="material-icons"></i></span>
                    <span style="color:#900; font-weight:bold; font-size:16px;">MAIN NAVIGATION</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <span><i class="fas fa-tachometer-alt"></i></span>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <span><i class="fa fa-sitemap"></i></span>
                    <span>Network</span>
                </a>
                <ul>
                    <li><a href="{{ route('gtree.index') }}"><i class="fa fa-ellipsis-h"></i> Genealogy Tree</a></li>
                    <li><a href="#"><i class="fa fa-ellipsis-h"></i>Binary List</a>
                    </li><li><a href="#"><i class="fa fa-ellipsis-h"></i>D/I Genealogy List</a>
                    </li><li><a href="{{ route('gtree.pairing') }}"><i class="fa fa-ellipsis-h"></i>Pair List</a>
                    </li> 
                </ul>
            </li>
            <li>
                <a href="#">
                    <span><i class="fa fa-bar-chart"></i></span>
                    <span>Commissions</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <span><i class="fa fa-envelope"></i></span>
                    <span>Mail</span>
                </a>
                <ul>
                    <li><a href="#"><i class="fa fa-ellipsis-h"></i> Code Vault</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#">
                    <span><i class="fa fa-shopping-bag"></i></span>
                    <span>Product Unilevel</span>
                </a>
                <ul>
                    <li><a href="#"><i class="fa fa-ellipsis-h"></i> Product Activation</a>
                    </li>
                    <li><a href="#"><i class="fa fa-ellipsis-h"></i> Purchase Summary</a>
                    </li>

                </ul> 
            </li>
            <li>
                <a href="#">
                    <span><i class="fas fa-wallet"></i></span>
                    <span>E-Wallet</span>
                </a>
                <ul>
                    <li><a href="#"><i class="fa fa-ellipsis-h"></i> My E-Wallet</a>
                    </li>
                    <li><a href="#"><i class="fa fa-ellipsis-h"></i> Transactions History</a>
                    </li>

                </ul>  
            </li>
            <li>
                <a href="#">
                    <span><i class="fas fa-cogs"></i></span>
                    <span>Settings</span>
                </a>
                <ul>
                    <li><a href="#"><i class="fa fa-ellipsis-h"></i> Switch Account</a></li>
                    <li><a href="#"><i class="fa fa-ellipsis-h"></i> Edit Profile</a></li>
                    <li><a href="#"><i class="fa fa-ellipsis-h"></i> Change Password</a></li>

                </ul>  
            </li>
            <li> 
                <a href="#">
                    <span><i class="fa fa-certificate"></i></span>
                    <span>COURSES</span>
                </a>
            </li>
            <li>
                <a href="#" onclick="event.preventDefault();
                                               document.getElementById('logout-form').submit();">
                    <span><i class="fa fa-power-off"></i></span>
                    <span>Logout</span>
                </a>
                
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </nav>
</section>