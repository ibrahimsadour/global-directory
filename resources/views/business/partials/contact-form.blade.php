<div x-data="contactForm" class="overview services shadow-sm no-margin d-none ">
    <h2 class="border-bottom">اتصل بنا</h2>
    <form @submit.prevent="handleSubmit">
        <div x-show="success" class="alert alert-success m-3 mb-0" role="alert" style="display: none;">
            Your Message Submited Sucessfully
        </div>
        <div class="form-cover">
            <input type="text" @focus="removeError('name')" x-model="name" :class="{ 'is-invalid':  errors.name !== undefined }" class="form-control mb-0" placeholder="Full Name">
            <div x-show="errors.name != undefined" class="invalid-feedback" x-text="errors.name" style="display: none;"></div>
            <input type="text" @focus="removeError('mobile')" x-model="mobile" :class="{ 'is-invalid':  errors.mobile !== undefined }" class="form-control mt-3 mb-0" placeholder="Enter Mobile Number">
            <div x-show="errors.mobile != undefined" class="invalid-feedback" x-text="errors.mobile" style="display: none;"></div>
            <input type="text" @focus="removeError('email')" x-model="email" :class="{ 'is-invalid':  errors.email !== undefined }" class="form-control mt-3 mb-0" placeholder="Email Address ">
            <div x-show="errors.email != undefined" class="invalid-feedback" x-text="errors.email" style="display: none;"></div>
            <textarea name="" @focus="removeError('message')" x-model="message" :class="{ 'is-invalid':  errors.message !== undefined }" placeholder="Enter Message" id="" class="form-control mt-3 mb-0" rows="4"></textarea>
            <div x-show="errors.message != undefined" class="invalid-feedback" x-text="errors.message" style="display: none;"></div>
            <button x-show="!process" type="submit" class="btn btn-primary mt-3 w-100">Send Message</button>
            <button x-show="process" disabled="true" class="btn btn-primary mt-3 w-100" style="display: none;">Send Message</button>
        </div>
    </form>
</div>