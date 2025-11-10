@php
    $logoPath = public_path('images/logo.jpg');
    $logoBase64 = base64_encode(file_get_contents($logoPath));
    $logoMime = mime_content_type($logoPath);
@endphp

@extends('layouts.admin')

@section('title', 'الوكالات و الاتفاقيات')
@section('main_title_content', 'قائمة الوكالات و الاتفاقيات')
@section('title_content', 'عرض')
@section('link_content')
    <a href="{{ route('agencies.index', $main) }}">اتفاقيات</a>
@endsection

@section('content')
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5>كل الوكالات التابعة لـ {{ $main->name ?? '' }}</h5>
            <a href="{{ route('agencies.create', $main->id) }}" class="btn btn-primary btn-sm">
                + إنشاء وكالة جديدة
            </a>
        </div>

        <div class="card-body">
            @if ($agencies->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-striped text-center align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>رقم الوكاله</th>
                                <th>الوكاله</th>
                                <th>التحكم</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($agencies as $index => $agency)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td class="agency-text">
                                        انا / نحن <strong> {{ $agency->user->name }}</strong> .الموقعـ أدناه قد وكلـ وأقمـ
                                        مقام نفسـ المحامي <strong> عمر موسى الشبول و {{ $agency->lawyers }} </strong>
                                        .مجتمعين ومنفردين لينوبا ويقوما عنـي بتقديم وإقامة الدعوى / القضية / الطلب /
                                        والمرافعة والمدافعة والمحاكمة والمخاصمة والمخالصة والمراجعة في الدعوى التي موضوعها
                                        <strong>{{ $agency->letter }}</strong> أو التي ستتكون بينـ وبين
                                        <strong>{{ $agency->opponents }}</strong> لدى محكمة
                                        <strong>{{ $agency->court }}</strong> أو المحاكم الاخرى على إختلاف أنواعها ووظائفها
                                        ودرجاتها صلحاً وبداية وإعتراضاً وإستئنافاً وتمييزاً وإعادة وتصحيحاً ولدى محكمة العدل
                                        العليا وأمام محاكم الأراضي والتسوية ولدى محكمة إستئناف ضريبة الدخل والمحاكم الجمركية
                                        بكافة درجاتها ومحاكم العشائر والمحاكم العسكرية والمجالس العرفية والمحاكم العمالية
                                        والصناعية ومجالس التوفيق عامة وسلطة الاجور والنيابة العامة وكافة الدوائر والمجالس
                                        والهيئات والسلطات رسمية أو شبه رسمية أو أهلية قضائية أو غير قضائية ولدى
                                        <strong>{{ $agency->for }}</strong> ودائرة ضريبة الدخل ومأموري التقدير والموظفين
                                        المنابين ومراقب الشركات ومسجل العلامات التجارية والاسماء التجارية وكافة المسجلين
                                        وحراس القضاء وطوابق الافلاس والسنديك والمصفين والمقيمين في عزلهم وتعيين غيرهم
                                        وإنتخابهم والاعتراض على تعيينهم وعلى قرارتهم والطعن فيها وفي طلب التفليسة وإنتخاب
                                        أهل الخبرة والمحكمين والمميزين والمصلحين وعزلهم و إتخاذ كافة إجراءات التحكيم
                                        وبالاجمال أمام كافة المحاكم والدوائر والمجالس والهيئات والسلطات على إختلاف أنواعها
                                        ووظائفها ،وفي جميع الدعاوى والخلافات والمراجعات على السواء أكانت مدنية أم تجارية أم
                                        جزائية أم شرعية أم إدارية أم مالية أم ضرائبية أم عسكرية أم أحوال شخصية وفي كافة
                                        الدعاوى واللوائح والانذارات وتوجيه أوامر الدفع والاستدعاءات والتوقيع عليها وما يلزم
                                        من الاوراق والمستندات وفي التبليغ والتبلغ وإقامة البينة وحصرها وإظهار العجز عنها وفي
                                        تقديم الدفاع والدعوى المتقابلة وفي الدخول أو الادخال بصفة شخص ثالث وفي أعتراض الغير
                                        وفي طلب التحليف ورده والنكول عنه والتحالف والصلح والابراء والاسقاط والاقرار غير
                                        المضر وفي إنكار التوقيع ،وفي انكار الدين ،وفي طلب الحجز التحفظي وتثبيته أو فكه وفي
                                        طلب الفائدة القانونية وفي تسجيل وتصفية الشركات على إختلاف أنواعها وفي طلب إجراء
                                        المحاسبة ونقل الدعوى ورد الأعضاء والاشتكاء على الحاكم ومراجعة دوائر الاجراء وفي كافة
                                        المعاملات الاجرائية وفي القبض والصلح والاقرار والايصال والصرف وطلب الحبس والتنفيذ
                                        وقبول التسوية ورفضها وفي جميع ما يجوز التوكيل فيه شرعاً وقانوناً ذكر أم لم يذكر ولو
                                        كان ذكره مشروطاً وكالة مطلقة بالخصوص الموكل به وما يتفرع عنه مفوض لرأيه وقوله وفعله
                                        وله أن يوكل أو ينيب من يشاء بما وكل به كله أو ببعضعه وعليه أوقع. نظمت في هذا اليوم
                                        <strong>{{ $agency->created_at->format('d') }}</strong> من شهر
                                        <strong>{{ $agency->created_at->format('m') }}</strong> لسنة
                                        <strong>20{{ $agency->created_at->format('y') }}</strong> اصادق على صحة التوقيع
                                        والموكل
                                    </td>
                                    <td>
                                        <a href="{{ route('agencies.edit', [$agency->id]) }}"
                                            class="btn btn-warning btn-sm mb-2 d-block">
                                            تعديل
                                        </a>
                                        <form action="{{ route('agencies.delete', [$agency->id]) }}" method="POST"
                                            onsubmit="return confirm('هل أنت متأكد أنك تريد حذف هذه الوكالة؟');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm d-block">
                                                حذف
                                            </button>
                                        </form>
                                        <button type="button" class="btn btn-info btn-sm mt-2 print-agency">
                                            طباعة الوكالة
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center text-muted py-4">
                    لا توجد وكالات حالياً.
                </div>
            @endif
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const logoBase64 = "data:{{ $logoMime }};base64,{{ $logoBase64 }}";

            document.querySelectorAll('.print-agency').forEach(btn => {
                btn.addEventListener('click', function() {
                    const agencyText = this.closest('tr').querySelector('.agency-text').innerHTML;

                    const printWindow = window.open('', '', 'height=1000,width=900');
                    printWindow.document.write(`
                <html>
                <head>
                    <title>طباعة الوكالة</title>
                    <style>
                        @media print {
                            body {
                                margin: 10mm;
                            }
                            .container {
                                page-break-inside: avoid;
                            }
                        }
                        body {
                            font-family: Arial, sans-serif;
                            margin: 20px;
                            text-align: center;
                        }
                        .container {
                            max-width: 900px;
                            margin: auto;
                            padding: 20px;
                            border: 1px solid #000;
                        }
                        .logo {
                            display: block;
                            margin: 0 auto 30px auto;
                            width: 600px;
                            height: 100px;
                        }
                        .agency-text {
                            text-align: justify;
                            line-height: 1.6;
                            margin-bottom: 50px;
                        }
                        .signatures {
                            display: flex;
                            justify-content: space-between;
                            margin-top: 50px;
                        }
                        .signature-box {
                            width: 40%;
                            text-align: center;
                        }
                        .signature-line {
                            margin-top: 80px;
                            border-top: 1px solid #000;
                        }
                    </style>
                </head>
                <body>
                    <div class="container">
                        <img src="${logoBase64}" class="logo" alt="Logo">
                        <div class="agency-text">${agencyText}</div>
                        <div class="signatures">
                            <div class="signature-box">
                                الموكل
                                <div class="signature-line"></div>
                            </div>
                            <div class="signature-box">
                                المحامي
                                <div class="signature-line"></div>
                            </div>
                        </div>
                    </div>
                </body>
                </html>
            `);

                    printWindow.document.close();
                    printWindow.print();
                });
            });
        });
    </script>
@endsection
