@extends('admin_master')
@section('admin')

<div class="page-content">
    <div class="container-fluid">

        <!-- Page Title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Bulk SMS</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('sms.dashboard') }}">SMS</a></li>
                            <li class="breadcrumb-item active">Bulk SMS</li>
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
                            <i class="ri-send-plane-fill"></i> Send Bulk SMS
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('sms.sendBulk') }}" method="POST" id="bulkSmsForm">
                            @csrf

                            <!-- Recipient Filter -->
                            <div class="mb-3">
                                <label for="filter" class="form-label">Select Recipients <span class="text-danger">*</span></label>
                                <select class="form-select" id="filter" name="filter" required>
                                    <option value="">-- Select recipient group --</option>
                                    @foreach($filters as $key => $label)
                                        <option value="{{ $key }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Preview Recipients -->
                            <div class="mb-3" id="preview-section" style="display: none;">
                                <div class="alert alert-info">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <i class="ri-information-line fs-20"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <strong>Total Recipients:</strong> <span id="recipient-count">0</span>
                                            <br>
                                            <small id="preview-list"></small>
                                        </div>
                                    </div>
                                </div>
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
                            </div>

                            <!-- Message -->
                            <div class="mb-3">
                                <label for="message" class="form-label">Message <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="message" name="message" rows="6"
                                          placeholder="Type your message here..." required maxlength="480"></textarea>
                                <div class="d-flex justify-content-between mt-1">
                                    <small class="text-muted">Characters: <span id="char-count">0</span>/480</small>
                                    <small class="text-muted">SMS per person: <span id="sms-count">0</span></small>
                                </div>
                                <div class="mt-1">
                                    <small class="text-warning">
                                        <strong>Total SMS:</strong> <span id="total-sms">0</span>
                                        (<span id="recipient-count-2">0</span> recipients × <span id="sms-count-2">0</span> SMS each)
                                    </small>
                                </div>
                            </div>

                            <!-- Confirmation -->
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="confirm" required>
                                    <label class="form-check-label" for="confirm">
                                        I confirm that I want to send this message to <strong><span id="recipient-count-3">0</span></strong> recipients
                                    </label>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('sms.dashboard') }}" class="btn btn-light">
                                    <i class="ri-arrow-left-line"></i> Back
                                </a>
                                <button type="submit" class="btn btn-primary" id="sendBtn" disabled>
                                    <i class="ri-send-plane-fill"></i> Send Bulk SMS
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Info -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header bg-soft-warning">
                        <h5 class="card-title mb-0 text-warning">
                            <i class="ri-alert-line"></i> Important
                        </h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">
                                <i class="ri-arrow-right-s-line text-warning"></i>
                                Preview recipients before sending
                            </li>
                            <li class="mb-2">
                                <i class="ri-arrow-right-s-line text-warning"></i>
                                Double-check your message
                            </li>
                            <li class="mb-2">
                                <i class="ri-arrow-right-s-line text-warning"></i>
                                SMS cannot be recalled
                            </li>
                            <li class="mb-2">
                                <i class="ri-arrow-right-s-line text-warning"></i>
                                Consider sending time
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header bg-soft-success">
                        <h5 class="card-title mb-0 text-success">
                            <i class="ri-filter-line"></i> Filter Options
                        </h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0 small">
                            @foreach($filters as $key => $label)
                                <li class="mb-1">
                                    <i class="ri-arrow-right-s-line"></i> {{ $label }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
// Filter change - preview recipients
document.getElementById('filter').addEventListener('change', function() {
    const filter = this.value;
    if (!filter) {
        document.getElementById('preview-section').style.display = 'none';
        return;
    }

    // Fetch preview
    fetch('{{ route("sms.previewRecipients") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ filter: filter })
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('recipient-count').textContent = data.count;
        document.getElementById('recipient-count-2').textContent = data.count;
        document.getElementById('recipient-count-3').textContent = data.count;

        if (data.count > 0) {
            const previewList = data.recipients.slice(0, 5).map(r =>
                `${r.phone}${r.name ? ' (' + r.name + ')' : ''}`
            ).join(', ');
            document.getElementById('preview-list').textContent =
                `Sample: ${previewList}${data.count > 5 ? ', ...' : ''}`;
            document.getElementById('preview-section').style.display = 'block';
        }

        updateTotalSms();
    });
});

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
    document.getElementById('sms-count-2').textContent = smsCount;

    updateTotalSms();
}

function updateTotalSms() {
    const recipientCount = parseInt(document.getElementById('recipient-count').textContent) || 0;
    const smsCount = parseInt(document.getElementById('sms-count').textContent) || 0;
    const totalSms = recipientCount * smsCount;
    document.getElementById('total-sms').textContent = totalSms;
}

// Enable send button only when confirmed
document.getElementById('confirm').addEventListener('change', function() {
    document.getElementById('sendBtn').disabled = !this.checked;
});

// Form submission confirmation
document.getElementById('bulkSmsForm').addEventListener('submit', function(e) {
    const recipientCount = parseInt(document.getElementById('recipient-count').textContent) || 0;
    const totalSms = parseInt(document.getElementById('total-sms').textContent) || 0;

    if (!confirm(`Are you sure you want to send ${totalSms} SMS to ${recipientCount} recipients?`)) {
        e.preventDefault();
    }
});
</script>

@endsection
