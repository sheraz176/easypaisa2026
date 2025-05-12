<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        @page {
            size: A4 landscape;
            margin: 10mm;
        }

          @font-face {
    font-family: 'Jameel Noori Nastaleeq';
    src: url('{{ public_path('fonts/jameel_noori_nastaleeq.ttf') }}') format('truetype');
}

    .urdu-text {
        font-family: 'Jameel Noori Nastaleeq', sans-serif;
        direction: rtl;
        text-align: right;
    }

        body {
            font-family: Arial, 'notonastaliq', sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }

        .urdu {
            font-family: 'notonastaliq', 'Arial Unicode MS', sans-serif;
            direction: rtl;
            text-align: right;
        }

        .english {
            font-family: Arial, sans-serif;
            direction: ltr;
            text-align: left;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }

        th, td {
            border: 1px solid #000;
            padding: 4px;
        }

        h3 {
            margin: 6px 0;
        }

        p {
            margin: 2px 0;
        }

        .dual-language {
            display: flex;
            justify-content: space-between;
        }

        .header .document-title,
        .header .company-name {
            text-align: center;
            margin: 2px 0;
        }
    </style>
</head>
<body>
    
    <div class="urdu-text">
   ای ایف یو لائف اشورنس
</div>
    <div class="header">
        <div class="company-name english">EFU Life Assurance Ltd</div>
        <div class="company-name urdu">ای ایف یو لائف اشورنس لمیٹڈ</div>
        <div class="document-title english">Window Takaful Operations</div>
        <div class="document-title urdu">ونڈو تکافل آپريشنز</div>
        <div class="document-title english">Illustration of Benefits for EasyPaisa Takaful Savings Plan</div>
        <div class="document-title urdu">فوائد کی تصریح براۓ ایزی پیسہ تکافل سیونگس پلان</div>
    </div>

    <div class="dual-language">
        <p class="english">Prepared for {{ $name }}</p>
        <p class="urdu">تیار شدہ برائے {{ $name }}</p>
    </div>

    <h3 class="english">Basic Details</h3>
    <h3 class="urdu">بنیادی تفصیلات</h3>
    <table>
        <tr>
            <th class="english">Name of Participant</th>
            <th class="urdu">نام براۓ شریکِ تکافل</th>
            <td>{{ $name }}</td>
            <th class="english">Date of birth</th>
            <th class="urdu">تاریخ پیدائش</th>
            <td>{{ date('d/m/Y', strtotime($dob)) }}</td>
        </tr>
        <tr>
            <th class="english">Expected Commencement Date</th>
            <th class="urdu">متوقع تاریخ آغاز</th>
            <td>{{ date('d/m/Y') }}</td>
            <th class="english">Valid Till</th>
            <th class="urdu">تاریخ تک معتبر</th>
            <td>{{ date('d/m/Y', strtotime('+3 years')) }}</td>
        </tr>
    </table>

    <h3 class="english">Coverage Details</h3>
    <h3 class="urdu">تحفظ کی تفصیلات</h3>
    <table>
        <tr>
            <th class="english">Currency of Plan</th>
            <th class="urdu">پلان کی کرنسی</th>
            <td>Rupees</td>
            <td>روپے</td>
            <th class="english">Mode of Payment</th>
            <th class="urdu">ادائیگی کا طریقہ کار</th>
            <td>Single</td>
            <td>سنگل</td>
        </tr>
        <tr>
            <th class="english">Type</th>
            <th class="urdu">نوعیت</th>
            <td>Level</td>
            <td>سادہ</td>
            <th class="english">Name of Plan</th>
            <th class="urdu">پلان کا نام</th>
            <td colspan="2">EasyPaisa Takaful Savings Plan [ Protection Multiple = 1.25 ]</td>
        </tr>
        <tr>
            <th class="english">Sum Covered</th>
            <th class="urdu">سم کورڈ</th>
            <td>{{ number_format($sum_covered) }}</td>
            <th class="english">Coverage Term</th>
            <th class="urdu">مدت تحفظ</th>
            <td>{{ $contribution_term }}</td>
            <th class="english">Single Contribution</th>
            <th class="urdu">سنگل زرِ تکافل</th>
            <td>{{ number_format($amount) }}</td>
        </tr>
        <tr>
            <th class="english">Accidental Death Benefit (Built in)</th>
            <th class="urdu">حادثاتی موت کا فائدہ (اندرونی)</th>
            <td>{{ number_format($sum_covered) }}</td>
            <td>{{ $contribution_term }}</td>
            <td>-</td>
            <td>-</td>
            <th class="english">Total Single Contribution</th>
            <th class="urdu">کل سنگل کا زرِتکافل</th>
            <td>{{ number_format($amount) }}</td>
        </tr>
    </table>

    <h3 class="english">Illustrative Values</h3>
    <h3 class="urdu">تصريحی ماليت</h3>
    <div class="dual-language">
        <p class="english">The table below provides expected benefits under the EasyPaisa Takaful Savings Plan for its duration</p>
        <p class="urdu">نیچے دی گئی جدول پیسہ تکافل سیونگس پلان کے تحت اس کی مدت کے لیے متوقع فوائد فراہم کرتی ہے۔</p>
    </div>
    <div class="dual-language">
        <p class="english">Expected Cash / surrender values are net of all charges including takaful donation, policy admin fee, fund management charges etc.</p>
        <p class="urdu">متوقع نقد ماليت تمام اخراجات کی کٹوتی کے بعد ہے، جیسے کہ ڈونيشن، انتظامی فیس، فنڈ چارجز وغیرہ۔</p>
    </div>

    <table>
        <tr>
            <th rowspan="2">Policy Year</th>
            <th rowspan="2">پالیسی کا سال</th>
            <th rowspan="2">Cumulative Contributions</th>
            <th rowspan="2">ادا شدہ زرِ تکافل</th>
            <th rowspan="2">Allocated to Fund</th>
            <th rowspan="2">مختص رقم</th>
            <th colspan="2">9% Return</th>
            <th colspan="2">13% Return</th>
        </tr>
        <tr>
            <th>Surrender Value + FAC</th>
            <th>Death Benefit</th>
            <th>Surrender Value + FAC</th>
            <th>Death Benefit</th>
        </tr>
        <tr>
            <td>1</td><td>{{ number_format($amount) }}</td><td>{{ number_format($amount) }}</td>
            <td>{{ number_format($amount * 1.04, 0) }}</td><td>{{ number_format($sum_covered) }}</td>
            <td>{{ number_format($amount * 1.05945, 0) }}</td><td>{{ number_format($sum_covered) }}</td>
        </tr>
        <tr>
            <td>2</td><td>{{ number_format($amount) }}</td><td>{{ number_format($amount) }}</td>
            <td>{{ number_format($amount * 1.0816, 0) }}</td><td>{{ number_format($sum_covered) }}</td>
            <td>{{ number_format($amount * 1.12125, 0) }}</td><td>{{ number_format($sum_covered) }}</td>
        </tr>
        <tr>
            <td>3</td><td>{{ number_format($amount) }}</td><td>{{ number_format($amount) }}</td>
            <td>{{ number_format($amount * 1.12485, 0) }}</td><td>{{ number_format($sum_covered) }}</td>
            <td>{{ number_format($amount * 1.1855, 0) }}</td><td>{{ number_format($sum_covered) }}</td>
        </tr>
    </table>

    <h3 class="english">Notes</h3>
    <h3 class="urdu">نوٹ</h3>
    <div class="dual-language">
        <p class="english">Allocation charges deducted annually before fund allocation:</p>
        <p class="urdu">مختص چارجز ہر سال مختص کرنے سے پہلے منہا کیے گئے ہیں:</p>
    </div>
    <table style="width: 50%;">
        <tr>
            <th>Year</th><th>سال</th><th>Charges (%)</th><th>شرح (%)</th>
        </tr>
        <tr>
            <td>Year 1+</td><td>سال 1+</td><td>Nil</td><td>صفر</td>
        </tr>
    </table>
    <div class="dual-language">
        <p class="english">Illustration excludes partial surrenders.</p>
        <p class="urdu">تصريحی ماليت میں جزوی دستبرداری شامل نہيں۔</p>
    </div>
    <div class="dual-language">
        <p class="english">Death Benefit = Max(Sum Covered, Cash Value)</p>
        <p class="urdu">وفات کے فوائد = سم کورڈ یا نقد مالیت میں سے جو زیادہ ہو۔</p>
    </div>
    
</body>
</html>
