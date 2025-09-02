@extends('layouts.admin')
@section('title', 'الموكلين ')
@section('main_title_content', ' قائمة الموكلين ')
@section('title_content', 'عرض')
@section('link_content')
    <a href="{{ route('client.visit') }}"> موكلين</a>
@endsection

@section('content')
    <div class="container-fluid py-4">
        <!-- خانة البحث في منتصف الصفحة -->
        <div class="row mb-5">
            <div class="col-12 d-flex justify-content-center">
                <div class="input-group rounded-pill shadow" style="max-width: 400px;">
                    <span class="input-group-text bg-transparent border-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" id="clientSearch" class="form-control border-0 rounded-pill bg-light"
                        placeholder="ابحث باسم الموكل..." style="height: 50px;">
                    <button class="btn btn-primary rounded-pill px-4" type="button">
                        بحث
                    </button>
                </div>
            </div>
        </div>

        <!-- الكروت -->
        <div class="row g-4 justify-content-center" id="clientsContainer">
            @forelse ($data as $client)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 client-card mt-4">
                    <div class="card client-card h-100 shadow-sm border-0 rounded-3">
                        <div class="card-body text-center py-4 d-flex flex-column align-items-center">
                            <div class="client-avatar mx-auto mb-3"> <i class="fas fa-user fa-2x text-white"></i> </div>
                            <!-- الاسم فوق -->
                            <h5 class="card-title text-dark mb-3">{{ $client->name }}</h5>

                            <!-- الزرار تحته -->
                            <a href="{{ route('client.show', $client) }}"
                                class="btn btn-outline-primary btn-sm rounded-pill">
                                <i class="fas fa-eye me-1"></i> عرض التفاصيل
                            </a>
                        </div>

                        <div class="card-footer bg-transparent border-top-0 text-center">
                            <small class="text-muted">
                                <i class="fas fa-id-card me-1"></i> {{ $client->national_id ?? 'غير محدد' }}
                            </small>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="empty-state text-center py-5 bg-light rounded-3">
                        <div class="empty-state-icon mb-3">
                            <i class="fas fa-users fa-3x text-muted"></i>
                        </div>
                        <h4 class="text-muted">لا يوجد موكلين لعرضهم</h4>
                        <p class="text-muted mb-4">يمكنك إضافة موكلين جدد من خلال الزر بالأعلى</p>
                        <a href="#" class="btn btn-primary rounded-pill">
                            <i class="fas fa-plus me-1"></i> إضافة موكل جديد
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- رسالة عندما لا توجد نتائج بحث -->
        <div id="noResults" class="row d-none">
            <div class="col-12">
                <div class="alert alert-info text-center py-4">
                    <i class="fas fa-search fa-2x mb-3"></i>
                    <h4>لا توجد نتائج بحث</h4>
                    <p class="mb-0">لم يتم العثور على أي موكلين تطابق بحثك</p>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript لتشغيل البحث -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const searchInput = document.getElementById("clientSearch");
            const clientCards = document.querySelectorAll(".client-card");
            const noResults = document.getElementById("noResults");

            searchInput.addEventListener("keyup", function() {
                let filter = this.value.toLowerCase();
                let hasVisibleCards = false;

                clientCards.forEach(card => {
                    const cardTitle = card.querySelector(".card-title");
                    const text = cardTitle ? cardTitle.textContent.toLowerCase() : card.textContent
                        .toLowerCase();

                    if (text.includes(filter)) {
                        card.style.display = "";
                        hasVisibleCards = true;
                    } else {
                        card.style.display = "none";
                    }
                });

                // إظهار أو إخفاء رسالة عدم وجود نتائج
                if (hasVisibleCards) {
                    noResults.classList.add("d-none");
                } else {
                    noResults.classList.remove("d-none");
                }
            });
        });
    </script>

    <style>
        .client-avatar {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .client-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .client-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }

        .empty-state {
            background-color: #f8f9fa;
            border-radius: 10px;
        }

        .input-group:focus-within {
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25) !important;
        }
    </style>
@endsection
