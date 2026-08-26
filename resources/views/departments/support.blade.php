@extends('layouts.app')

@section('title', 'Help & Support')
@section('header-title', 'Help & Technical Support')

@section('content')
<div class="row g-4">
    <div class="col-md-8">
        <div class="card-custom p-4">
            <h2 class="h5 font-weight-bold mb-3" style="font-weight: 700; font-size: 16px;"><i class="bi bi-book me-2"></i> User Guides & System Documentation</h2>
            
            <div class="accordion" id="supportAccordion">
                <div class="accordion-item border rounded-3 mb-2">
                    <h2 class="accordion-header">
                        <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#acc1">
                            How do I enter a new Production Bundle?
                        </button>
                    </h2>
                    <div id="acc1" class="accordion-collapse collapse show" data-bs-parent="#supportAccordion">
                        <div class="accordion-body text-muted" style="font-size: 13px;">
                            Click on <strong>New Production Order</strong> or navigate to <strong>Entry Form</strong> in the top navigation. Select a Buyer to populate the corresponding Styles via AJAX, enter Quantity, Completed, and Rejected counts. The system will calculate Balance Qty, Efficiency %, and Rejection % automatically in real time.
                        </div>
                    </div>
                </div>

                <div class="accordion-item border rounded-3 mb-2">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#acc2">
                            How do I export filtered Bundle data to Excel or CSV?
                        </button>
                    </h2>
                    <div id="acc2" class="accordion-collapse collapse" data-bs-parent="#supportAccordion">
                        <div class="accordion-body text-muted" style="font-size: 13px;">
                            Navigate to <strong>Listing</strong> or the sidebar <strong>Reports</strong> section. Apply any active filters (Buyer, Style, Line, Date Range) and click <strong>Export Excel</strong> or <strong>Export CSV</strong> to download your report instantly.
                        </div>
                    </div>
                </div>

                <div class="accordion-item border rounded-3">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#acc3">
                            How to connect to REST APIs using Postman or external apps?
                        </button>
                    </h2>
                    <div id="acc3" class="accordion-collapse collapse" data-bs-parent="#supportAccordion">
                        <div class="accordion-body text-muted" style="font-size: 13px;">
                            Use the included <code>postman_collection.json</code>. First send a <code>POST</code> request to <code>/api/v1/login</code> with credentials to obtain a Sanctum Bearer token, then pass <code>Authorization: Bearer &lt;token&gt;</code> for all API endpoints.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card-custom p-4">
            <h2 class="h5 font-weight-bold mb-3" style="font-weight: 700; font-size: 16px;"><i class="bi bi-headset me-2"></i> Contact Technical Support</h2>
            <p class="text-muted" style="font-size: 13px;">For factory floor system issues, database configuration, or custom ERP integrations, contact our support team:</p>
            <ul class="list-unstyled mb-4" style="font-size: 13px; line-height: 2;">
                <li><i class="bi bi-envelope-fill me-2 text-primary"></i> support@pro-erp-manufacturing.com</li>
                <li><i class="bi bi-telephone-fill me-2 text-success"></i> +1 (800) 555-4321</li>
                <li><i class="bi bi-clock-fill me-2 text-warning"></i> 24/7 Factory Helpdesk</li>
            </ul>
            <a href="mailto:support@pro-erp-manufacturing.com" class="btn btn-black w-100"><i class="bi bi-send me-1"></i> Send Support Ticket</a>
        </div>
    </div>
</div>
@endsection
