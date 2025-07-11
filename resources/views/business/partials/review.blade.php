{{-- التقيمات --}}
<section x-data="review" x-init="loadReviews()">
    <div id="revbox" class="review-box overview shadow-sm">
        <h2 class="border-bottom">التقيمات</h2>

        <!-- عرض رسالة إذا لم يكن هناك تقييمات -->
        @if(auth()->check())
            @if($review ->isEmpty())
                <div class="alert alert-info mt-4">
                    لا توجد تقييمات حتى الآن، <a href="#add-review" class="text-primary underline">أضف تقييمك الآن</a>.
                </div>
            @endif
        @else
            <div class="alert alert-warning mt-4">
                قم <a href="/login" class="text-primary underline">بتسجيل الدخول</a> أو 
                <a href="/register" class="text-primary underline">إنشاء حساب</a> لإضافة تقييمك.
            </div>
        @endif

        <!-- عرض التقييمات -->
        <template x-for="(r, i) in reviews" :key="r.id">
            <div class="row reviewrow">
                <!-- صورة المستخدم -->
                <div class="col-md-2 col-3 center">
                    <img :src="r.user.resize" class="rounded-circle border border-1 p-2" alt="">
                </div>

                <!-- محتوى التقييم -->
                <div class="col-md-10 col-9 align-content-center rcolm">
                    <!-- النجوم -->
                    <div class="review mb-1">
                        <i class="bi bi-star-fill" :class="{ 'act': r.rating >= 1 }"></i>
                        <i class="bi bi-star-fill" :class="{ 'act': r.rating >= 2 }"></i>
                        <i class="bi bi-star-fill" :class="{ 'act': r.rating >= 3 }"></i>
                        <i class="bi bi-star-fill" :class="{ 'act': r.rating >= 4 }"></i>
                        <i class="bi bi-star-fill" :class="{ 'act': r.rating >= 5 }"></i>
                    </div>

                    <!-- الاسم والتاريخ -->
                    <div class="mb-2">
                        <h3 class="mb-1 fs-6 fw-bold" x-text="r.user.name"></h3>
                        <p class="text-muted d-block" x-text="formatSince(r.dat)"></p>
                        
                    </div>

                    <!-- نص التقييم أو التعديل -->
                    <div class="review-text">
                        <span x-show="edit !== i" x-text="r.message"></span>
                        <textarea x-show="edit === i" x-model="r.message" class="form-control" cols="30" rows="3"></textarea>
                    </div>

                    <!-- أزرار التحكم -->
                    <ul x-show="r.user.id === uid" class="actionreview mt-2">
                        <div class="d-flex gap-2 align-items-center">
                            <button type="button" class="btn btn-danger btn-sm" @click="removeId = i; setTimeout(() => confirmRemove(), 50)">
                                <i class="bi bi-trash"></i> حذف
                            </button>

                            <li x-show="edit !== i" @click="editReview(i)" class="btn btn-primary btn-sm list-unstyled">
                                <i class="bi bi-pencil-square"></i> تعديل
                            </li>

                            <template x-if="edit === i">
                                <div class="d-flex gap-2">
                                    <li @click="updateReview(i)" class="btn btn-success btn-sm list-unstyled">
                                        <i class="bi bi-check2-square"></i> حفظ
                                    </li>
                                    <li @click="edit = -1" class="btn btn-secondary btn-sm list-unstyled">
                                        <i class="bi bi-x-circle"></i> إلغاء
                                    </li>
                                </div>
                            </template>
                        </div>
                    </ul>
                </div>
            </div>
        </template>

        <!-- زر المزيد إن وُجد -->
        @if(!empty($review) && count($review) >= 5)
            <div class="div m-1 pb-1">
                <button x-show="showMore" id="rivmore" @click="lodeMoreReview" type="button" class="btn morefont w-100 btn-outline-primary">عرض المزيد من التقيمات</button>
            </div>
        @endif
    </div>

    @auth
        @if(!$myReview)
            <div class="add-review overview shadow-sm">
                <h2 class="border-bottom">اضافة تقيم</h2>

                <div x-show="success" class="succmsg p-3 pb-0">
                    <div class="alert alert-success mb-0" role="alert">
                       تمت اضافة تقيمك بنجاح
                    </div>
                </div>

                <div class="row p-3" id="add-review">
                    <div class="col-md-12 add-reviwcol">
                        <li class="rev mb-3">
                            <label>اختر عدد النجوم:</label>
                            <template x-for="s in 5">
                                <i @click="addStar(s)" class="bi bi-star-fill" :class="{ 'act': star >= s }"></i>
                            </template>
                        </li>

                        <form @submit.prevent="postReview">
                            <div class="col-md-12">
                                <textarea x-model="message" :class="{ 'inerror': error.message !== undefined }" class="form-control mb-1" placeholder="Enter Your Message" cols="30" rows="5"></textarea>
                                <div x-show="error.message != undefined" class="smart-valid" x-text="error.message"></div>
                            </div>
                            <div class="col-md-12 mt-3 text-end">
                                <button x-show="!process" class="btn btn-primary">ارسال تقيمك</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-info mt-3">
                لقد قمت مسبقًا بإضافة تقييم لهذا النشاط. يمكنك تعديل التقييم من القائمة أعلاه.
            </div>
        @endif
    @endauth

</section>

