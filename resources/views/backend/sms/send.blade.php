@extends('admin_master')
@section('admin')

<div class="page-content">
    <div class="container-fluid">

        <!-- Page Title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Send SMS</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('sms.dashboard') }}">SMS</a></li>
                            <li class="breadcrumb-item active">Send SMS</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="ri-send-plane-2-line"></i> Send Single SMS
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('sms.sendSingle') }}" method="POST">
                            @csrf

                            <!-- Phone Number -->
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="phone" name="phone"
                                       placeholder="0712345678 or 254712345678" required>
                                <small class="text-muted">Supports formats: 0712..., 712..., or 254712...</small>
                            </div>

                            <!-- Message Template -->
                            <div class="mb-3">
                                <label for="template" class="form-label">Use Template (Optional)</label>
                                <select class="form-select" id="template">
                                    <option value="">-- Select a template --</option>
                                    @foreach($templates as $key => $template)
                                        <option value="{{ $template }}">{{ ucwords(str_replace('_', ' ', $key)) }}</option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Select a template to auto-fill the message</small>
                            </div>

                            <!-- Message -->
                            <div class="mb-3">
                                <label for="message" class="form-label">Message <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="message" name="message" rows="6"
                                          placeholder="Type your message here..." required maxlength="480"></textarea>
                                <div class="d-flex justify-content-between mt-1">
                                    <small class="text-muted">Characters: <span id="char-count">0</span>/480</small>
                                    <small class="text-muted">SMS Count: <span id="sms-count">0</span></small>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('sms.dashboard') }}" class="btn btn-light">
                                    <i class="ri-arrow-left-line"></i> Back
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="ri-send-plane-fill"></i> Send SMS
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Tips & Info -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header bg-soft-info">
                        <h5 class="card-title mb-0 text-info">
                            <i class="ri-lightbulb-line"></i> Tips
                        </h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">
                                <i class="ri-checkbox-circle-fill text-success"></i>
                                Keep messages short and clear
                            </li>
                            <li class="mb-2">
                                <i class="ri-checkbox-circle-fill text-success"></i>
                                Include your business name
                            </li>
                            <li class="mb-2">
                                <i class="ri-checkbox-circle-fill text-success"></i>
                                Add a call-to-action
                            </li>
                            <li class="mb-2">
                                <i class="ri-checkbox-circle-fill text-success"></i>
                                Avoid special characters
                            </li>
                            <li class="mb-2">
                                <i class="ri-checkbox-circle-fill text-success"></i>
                                160 chars = 1 SMS
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header bg-soft-warning">
                        <h5 class="card-title mb-0 text-warning">
                            <i class="ri-information-line"></i> SMS Pricing
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-2"><strong>Standard SMS:</strong></p>
                        <ul class="mb-0">
                            <li>1-160 characters = 1 SMS</li>
                            <li>161-320 characters = 2 SMS</li>
                            <li>321-480 characters = 3 SMS</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
// Template selection
document.getElementById('template').addEventListener('change', function() {
    document.getElementById('message').value = this.value;
    updateCharCount();
});

// Character counter
const messageInput = document.getElementById('message');
messageInput.addEventListener('input', updateCharCount);

function updateCharCount() {
    const length = messageInput.value.length;
    document.getElementById('char-count').textContent = length;

    // Calculate SMS count
    let smsCount = 0;
    if (length === 0) smsCount = 0;
    else if (length <= 160) smsCount = 1;
    else if (length <= 320) smsCount = 2;
    else if (length <= 480) smsCount = 3;
    else smsCount = Math.ceil(length / 153);

    document.getElementById('sms-count').textContent = smsCount;
}
</script>

@endsection
