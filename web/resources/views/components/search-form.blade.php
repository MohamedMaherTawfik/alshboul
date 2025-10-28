  {{-- نموذج البحث --}}
  <div class="card shadow-sm mb-5 w-100">
      <div class="card-header bg-primary text-white py-3">
          <h5 class="mb-0"><i class="fas fa-search me-2"></i> نموذج البحث المتقدم</h5>
      </div>

      <div class="card-body">
          <form method="POST" action="{{ route('public.search.find') }}">
              @csrf

              <div class="row">
                  {{-- بحث المشترك --}}
                  <div class="col-md-4 mb-3">
                      <label class="form-label fw-bold">بحث المشترك</label>
                      <input type="text" name="client_name" class="form-control form-control-lg"
                          placeholder="ادخل اسم المشترك">
                  </div>

                  {{-- بحث الموكل --}}
                  <div class="col-md-4 mb-3">
                      <label class="form-label fw-bold">بحث الموكل</label>
                      <input type="text" name="client_belong" class="form-control form-control-lg"
                          placeholder="ادخل اسم الموكل">
                  </div>

                  {{-- بحث الخصم --}}
                  <div class="col-md-4
                          mb-3">
                      <label class="form-label fw-bold">بحث الخصم</label>
                      <input type="text" name="opponent_name" class="form-control form-control-lg"
                          placeholder="ادخل اسم الخصم">
                  </div>
              </div>

              <div class="row">
                  {{-- بحث القضية --}}
                  <div class="col-md-6 mb-3">
                      <label class="form-label fw-bold">بحث القضية</label>
                      <input type="text" name="case" class="form-control form-control-lg"
                          placeholder="ادخل رقم القضية">
                  </div>

                  {{-- بحث المحكمة --}}
                  <div class="col-md-6 mb-3">
                      <label class="form-label fw-bold">بحث المحكمة</label>
                      <input type="text" name="court" class="form-control form-control-lg"
                          placeholder="ادخل اسم المحكمة">
                  </div>
              </div>

              {{-- زرار البحث --}}
              <div class="text-center mt-4">
                  <button type="submit" class="btn btn-primary btn-lg px-5">
                      <i class="fas fa-search me-2"></i> بحث
                  </button>
              </div>
          </form>
      </div>
  </div>
