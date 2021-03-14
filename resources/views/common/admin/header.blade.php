<div class="row adminhead py-2">
    <div class="col-3">
        <span class="pagetitle100">ADMIN PANEL</span>
    </div>
    <div class="col-9 text-right">
        <span class="mr-2" style="color: #eee">You're Logged in as: [ UserName: <strong style="color: #fff">{{ Auth::user()->email }}</strong>]</span>
        <button class="btn btn-sm btn-success" onclick="event.preventDefault();
                                               document.getElementById('logout-form').submit();">
            Logout
        </button>
    </div>
</div>