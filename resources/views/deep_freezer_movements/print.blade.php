<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Freezer Movement Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            margin: 0;
            padding: 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .header-title h2 {
            margin: 0;
            font-size: 20px;
        }

        .header-title p {
            margin: 5px 0 0 0;
            font-size: 12px;
            color: #666;
        }

        .logo {
            font-size: 32px;
            font-weight: bold;
            color: #d11218;
            font-style: italic;
        }

        .text-center {
            text-align: center;
        }

        .form-title {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 40px;
        }

        .row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .col-half {
            width: 48%;
        }

        .field {
            display: flex;
            margin-bottom: 15px;
            align-items: center;
        }

        .field-label {
            font-weight: bold;
            width: 150px;
        }

        .field-value {
            flex-grow: 1;
            border-bottom: 1px solid #000;
            padding-left: 10px;
            min-height: 20px;
        }

        .section-title {
            font-weight: bold;
            margin-top: 30px;
            margin-bottom: 10px;
        }

        .retailer-box {
            border: 1px solid #000;
            padding: 15px;
            margin-bottom: 20px;
        }

        .retailer-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 15px;
        }

        .freezer-box {
            border: 1px solid #000;
            border-top: none;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            text-align: center;
        }

        .freezer-section {
            width: 48%;
        }

        .acknowledgement {
            font-size: 12px;
            text-align: center;
            font-weight: bold;
            margin: 15px 0;
        }

        .receiving-title {
            text-align: center;
            font-weight: bold;
            margin: 30px 0 20px 0;
            font-size: 14px;
        }

        .signatures-box {
            margin-top: 50px;
        }

        .signature-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .signature-field {
            display: flex;
            width: 45%;
            align-items: end;
        }

        .signature-field .label {
            width: 230px;
            font-weight: bold;
        }

        .signature-field .line {
            flex-grow: 1;
            border-bottom: 1px solid #000;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="no-print" style="margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; cursor: pointer;">Print Form</button>
    </div>

    <div class="header">
        <div class="header-title">
            <h2>Pakistan Fruit Juice Co. (Pvt.) Ltd.</h2>
            <p>Ice Cream Division</p>
        </div>
        <div class="logo">
            <!-- Hico logo placeholder -->
            Hico
        </div>
    </div>

    <div class="form-title">
        Freezer Movement Form
    </div>

    <div class="row">
        <div class="col-half">
            <div class="field">
                <div class="field-label">Vehicle Num :</div>
                <div class="field-value">{{ $movement->vehicleNo }}</div>
            </div>
            <div class="field">
                <div class="field-label">Retailer Code :</div>
                <div class="field-value">{{ $movement->customer->code ?? $movement->customer_id }}</div>
            </div>
            <div class="field">
                <div class="field-label">Movement Reason :</div>
                <div class="field-value">{{ $movement->reason }}</div>
            </div>
        </div>
        <div class="col-half">
            <div class="field">
                <div class="field-label">Driver Name :</div>
                <div class="field-value">{{ $movement->driver }}</div>
            </div>
            <div class="field">
                <div class="field-label">Doc Number :</div>
                <div class="field-value">{{ $movement->doc_no }}</div>
            </div>
            <div class="field">
                <div class="field-label">Movement Date :</div>
                <div class="field-value">{{ date('d/m/Y', strtotime($movement->date)) }}</div>
            </div>
        </div>
    </div>

    <div class="section-title">Retailer Information</div>

    <div style="border: 1px solid #000;">
        <div class="retailer-box" style="border: none; border-bottom: 1px solid #000;">
            <div class="retailer-grid">
                <div>
                    <strong>Retailer Name :</strong><br><br>
                    {{ $movement->customer->title }}
                </div>
                <div>
                    <strong>CNIC :</strong><br><br>
                    {{ $movement->customer->cnic }}
                </div>
                <div>
                    <strong>Contact Person :</strong><br><br>
                    {{ $movement->customer->title }}
                </div>
                <div>
                    <strong>Retailer Address :</strong><br><br>
                    {{ $movement->customer->address }}
                </div>
                <div>
                    <strong>Channel :</strong><br><br>
                    {{ $movement->customer->category }}
                </div>
                <div>
                    <strong>Mobile # :</strong><br><br>
                    {{ $movement->customer->contact }}
                </div>
            </div>
        </div>

        <div class="freezer-box" style="border: none;">
            <div class="freezer-section">
                <strong>Delivered Freezer</strong><br><br>
                {{ $movement->type == 'Issue' ? $movement->deep_freezer->code : '' }}
            </div>
            <div class="freezer-section">
                <strong>Collected Freezer</strong><br><br>
                {{ $movement->type == 'Collect' ? $movement->deep_freezer->code : '' }}
            </div>
        </div>
    </div>

    <div class="acknowledgement">
        Acknowledgement: Freezer(s) received undamaged for Hico Ice cream selling only. This is a property of PFJC,
        Pakistan, as per agreement
    </div>

    <div class="receiving-title">Freezer Receiving Acknowledgment</div>

    <div class="row" style="margin-top: 30px;">
        <div class="col-half">
            <div class="field">
                <div class="field-label" style="width: 120px;">Receiver Name :</div>
                <div class="field-value"></div>
            </div>
        </div>
        <div class="col-half">
            <div class="field">
                <div class="field-label" style="width: 150px;">Receiver Signature :</div>
                <div class="field-value"></div>
            </div>
        </div>
    </div>

    <div class="field" style="margin-top: 20px;">
        <div class="field-label" style="width: 100px;">Comments :</div>
        <div class="field-value"></div>
    </div>
    <div class="field" style="margin-top: 20px;">
        <div class="field-value"></div>
    </div>

    <div class="receiving-title" style="margin-top: 40px; margin-bottom: 30px;">For Office Use Only</div>

    <div class="signatures-box">
        <div class="signature-row">
            <div class="signature-field">
                <div class="label">Checked By TSM:</div>
                <div class="line"></div>
            </div>
            <div class="signature-field">
                <div class="label">Signature :</div>
                <div class="line"></div>
            </div>
        </div>
        <div class="signature-row">
            <div class="signature-field">
                <div class="label">Authorized By RSM:</div>
                <div class="line"></div>
            </div>
            <div class="signature-field">
                <div class="label">Signature :</div>
                <div class="line"></div>
            </div>
        </div>
        <div class="signature-row">
            <div class="signature-field">
                <div class="label">Entered In System By JMO:</div>
                <div class="line"></div>
            </div>
            <div class="signature-field">
                <div class="label">Signature :</div>
                <div class="line"></div>
            </div>
        </div>
        <div class="signature-row">
            <div class="signature-field">
                <div class="label">Gate officer:</div>
                <div class="line"></div>
            </div>
            <div class="signature-field">
                <div class="label">Signature :</div>
                <div class="line"></div>
            </div>
        </div>
        <div class="signature-row">
            <div class="signature-field">
                <div class="label">Cold Chain Manager:</div>
                <div class="line"></div>
            </div>
            <div class="signature-field">
                <div class="label">Signature :</div>
                <div class="line"></div>
            </div>
        </div>
    </div>
</body>

</html>
