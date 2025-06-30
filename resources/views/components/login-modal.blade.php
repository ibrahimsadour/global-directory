<!-- Modal -->
<div class="modal fade" id="loginAlert" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title fs-5" id="exampleModalLabel">تسجيل الدخول أو انشاء حساب جديد للمتابعة</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <center>
        <div class="modal-footer">
            <a href="{{ route('login') }}">
            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">تسجيل الدخول</button>
            </a>
            <a href="{{ route('register') }}">
            <button type="button" class="btn btn-primary" data-bs-dismiss="modal"> انشاء حساب جديد</button>
            </a>
        </div>
        </center>
    </div>
    </div>
</div>