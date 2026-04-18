<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pendaftaran Rider') }}
        </h2>
    </x-slot>

    <!-- intl-tel-input CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/18.1.5/css/intlTelInput.css">
    
    <div class="py-12" x-data="registrationForm()">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <!-- Progress Bar -->
                    <div class="mb-8">
                        <div class="flex justify-between mb-1">
                            <span class="text-xs font-semibold inline-block py-1 uppercase rounded-full text-tumbas">
                                Step <span x-text="step"></span> of 5
                            </span>
                        </div>
                        <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-orange-200">
                            <div :style="`width: ${(step/5)*100}%`" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-tumbas-light transition-all duration-300"></div>
                        </div>
                    </div>

                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 p-4 rounded text-red-700">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form x-ref="form" action="{{ route('rider.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Step 1: Personal Info -->
                        <div x-show="step === 1" x-transition.opacity>
                            <h3 class="text-lg font-bold mb-4">1. Informasi Pribadi</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium">Nama Lengkap</label>
                                    <input type="text" name="full_name" x-model="formData.full_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" :class="errors.full_name ? 'border-red-500' : ''">
                                    <p class="text-red-500 text-xs mt-1" x-show="errors.full_name" x-text="errors.full_name"></p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium">Email (Read Only)</label>
                                    <input type="email" disabled value="{{ auth()->user()->email }}" class="mt-1 block w-full bg-gray-100 rounded-md border-gray-300 shadow-sm">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium">Nomor HP</label>
                                    <div class="mt-1" wire:ignore>
                                        <input type="tel" id="phone_number_input" class="block w-full rounded-md border-gray-300 shadow-sm" :class="errors.phone_number ? 'border-red-500' : ''">
                                    </div>
                                    <input type="hidden" name="phone_number" x-model="formData.phone_number">
                                    <p class="text-red-500 text-xs mt-1" x-show="errors.phone_number" x-text="errors.phone_number"></p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium">Tanggal Lahir</label>
                                    <input type="date" name="birth_date" x-model="formData.birth_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" :class="errors.birth_date ? 'border-red-500' : ''">
                                    <p class="text-red-500 text-xs mt-1" x-show="errors.birth_date" x-text="errors.birth_date"></p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium">Gender</label>
                                    <select name="gender" x-model="formData.gender" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" :class="errors.gender ? 'border-red-500' : ''">
                                        <option value="">-- Pilih --</option>
                                        <option value="male">Laki-laki</option>
                                        <option value="female">Perempuan</option>
                                    </select>
                                    <p class="text-red-500 text-xs mt-1" x-show="errors.gender" x-text="errors.gender"></p>
                                </div>
                            </div>

                            <button type="button" @click="validateStep1()" class="mt-8 bg-tumbas hover:bg-tumbas-dark font-bold text-white px-6 py-2 rounded-full shadow-lg transition">Selanjutnya</button>
                        </div>


                        <!-- Step 2: Lokasi -->
                        <div x-show="step === 2" style="display: none;" x-transition.opacity>
                            <h3 class="text-lg font-bold mb-4">2. Detail Lokasi</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium">Alamat Lengkap (Jl, RT/RW, Kelurahan, Kecamatan)</label>
                                    <textarea name="address" x-model="formData.address" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" :class="errors.address ? 'border-red-500' : ''" placeholder="Tuliskan alamat domisili Anda selengkap mungkin..."></textarea>
                                    <p class="text-red-500 text-xs mt-1" x-show="errors.address" x-text="errors.address"></p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium">Kota Domisili</label>
                                    <input type="text" name="city" x-model="formData.city" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" :class="errors.city ? 'border-red-500' : ''" placeholder="Contoh: Surakarta">
                                    <p class="text-red-500 text-xs mt-1" x-show="errors.city" x-text="errors.city"></p>
                                </div>

                                <hr class="my-4">

                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <label class="block text-sm font-medium">Pilih Area Penempatan</label>
                                    <select name="selected_area_id" x-model="formData.selected_area_id" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm" :class="errors.selected_area_id ? 'border-red-500' : ''">
                                        <option value="">-- Pilih Area Penempatan --</option>
                                        <template x-for="area in areas" :key="area.id">
                                            <option :value="area.id" x-text="area.name"></option>
                                        </template>
                                    </select>
                                    <p class="text-red-500 text-xs mt-1" x-show="errors.selected_area_id" x-text="errors.selected_area_id"></p>
                                </div>
                            </div>

                            <div class="mt-6 flex justify-between">
                                <button type="button" @click="step--" class="bg-stone-200 hover:bg-stone-300 text-gray-700 font-bold px-6 py-2 rounded-full transition">Kembali</button>
                                <button type="button" @click="validateStep2()" class="bg-tumbas hover:bg-tumbas-dark font-bold text-white px-6 py-2 rounded-full shadow-lg transition">Selanjutnya</button>
                            </div>
                        </div>

                        <!-- Step 3: Pengalaman -->
                        <div x-show="step === 3" style="display: none;" x-transition.opacity>
                            <h3 class="text-lg font-bold mb-4">3. Pengalaman Kerja (Opsional, max 3)</h3>

                            <template x-for="(exp, index) in experiences" :key="index">
                                <div class="bg-white border-2 border-stone-100 p-6 mb-6 rounded-2xl relative shadow-sm hover:border-tumbas/20 transition-all group">
                                    <div class="absolute -top-3 -left-3 w-8 h-8 bg-tumbas text-white rounded-full flex items-center justify-center font-black text-sm shadow-lg" x-text="index + 1"></div>
                                    <button type="button" @click="removeExperience(index)" class="absolute top-4 right-4 text-red-400 hover:text-red-600 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-2">
                                        <div class="md:col-span-2">
                                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-1">Nama Perusahaan</label>
                                            <input type="text" :name="`experiences[${index}][company_name]`" x-model="exp.company_name" placeholder="Contoh: PT. Tumbas Kopi" class="block w-full rounded-xl border-gray-200 focus:border-tumbas focus:ring-tumbas transition-all">
                                            <p class="text-red-500 text-[10px] mt-1 font-bold" x-show="errors[`experiences.${index}.company_name`]" x-text="errors[`experiences.${index}.company_name`]"></p>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-1">Posisi / Jabatan</label>
                                            <input type="text" :name="`experiences[${index}][position]`" x-model="exp.position" placeholder="Contoh: Barista Rider" class="block w-full rounded-xl border-gray-200 focus:border-tumbas focus:ring-tumbas transition-all">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-1">Masa Kerja</label>
                                            <div class="flex items-center gap-2">
                                                <input type="date" :name="`experiences[${index}][start_date]`" x-model="exp.start_date" class="block w-full rounded-xl border-gray-200 text-sm focus:border-tumbas focus:ring-tumbas transition-all">
                                                <span class="text-gray-300 font-bold">-</span>
                                                <input type="date" :name="`experiences[${index}][end_date]`" x-model="exp.end_date" class="block w-full rounded-xl border-gray-200 text-sm focus:border-tumbas focus:ring-tumbas transition-all">
                                            </div>
                                            <p class="text-red-500 text-[10px] mt-1 font-bold" x-show="errors[`experiences.${index}.start_date`]" x-text="errors[`experiences.${index}.start_date`]"></p>
                                            <p class="text-red-500 text-[10px] mt-1 font-bold" x-show="errors[`experiences.${index}.end_date`]" x-text="errors[`experiences.${index}.end_date`]"></p>
                                        </div>
                                    </div>
                                </div>
                            </template>

                            <button type="button" @click="addExperience()" x-show="experiences.length < 3" class="bg-blue-100 text-blue-700 px-4 py-2 text-sm rounded shadow font-semibold mb-4 border border-blue-300">+ Tambah Pengalaman</button>

                            <div class="mt-6 flex justify-between">
                                <button type="button" @click="step--" class="bg-stone-200 hover:bg-stone-300 text-gray-700 font-bold px-6 py-2 rounded-full transition">Kembali</button>
                                <button type="button" @click="validateStep3()" class="bg-tumbas hover:bg-tumbas-dark font-bold text-white px-6 py-2 rounded-full shadow-lg transition">Selanjutnya</button>
                            </div>
                        </div>


                        <!-- Step 4: Upload -->
                        <div x-show="step === 4" style="display: none;" x-transition.opacity>
                            <h3 class="text-lg font-bold mb-4">4. Upload Dokumen</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="border p-4 rounded">
                                    <label class="block text-sm font-medium">Upload CV (PDF Only)</label>
                                    <input type="file" name="cv" x-ref="cv_input" @change="handleCvUpload" class="mt-2 text-sm" accept=".pdf">
                                    <p class="text-red-500 text-xs mt-1" x-show="errors.cv" x-text="errors.cv"></p>
                                    <div class="mt-4" x-show="cvFileName">
                                        <p class="text-xs text-green-600 font-bold mb-1">File Terpilih:</p>
                                        <p class="text-sm font-semibold truncate" x-text="cvFileName"></p>
                                    </div>
                                </div>
                                <div class="border p-4 rounded">
                                    <label class="block text-sm font-medium">Pas Foto (JPG/PNG)</label>
                                    <input type="file" name="photo" x-ref="photo_input" @change="handlePhotoUpload" class="mt-2 text-sm" accept="image/*">
                                    <p class="text-red-500 text-xs mt-1" x-show="errors.photo" x-text="errors.photo"></p>
                                    <div class="mt-4" x-show="photoPreview">
                                        <p class="text-xs text-gray-500 mb-1">Preview:</p>
                                        <img :src="photoPreview" class="h-32 object-cover bg-gray-100 rounded w-32">
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6 flex justify-between">
                                <button type="button" @click="step--" class="bg-stone-200 hover:bg-stone-300 text-gray-700 font-bold px-6 py-2 rounded-full transition">Kembali</button>
                                <button type="button" @click="validateStep4()" class="bg-tumbas hover:bg-tumbas-dark font-bold text-white px-6 py-2 rounded-full shadow-lg transition">Review Data</button>
                            </div>
                        </div>

                        <!-- Step 5: Review & Submit -->
                        <div x-show="step === 5" style="display: none;" x-transition.opacity>
                            <h3 class="text-lg font-bold mb-4">5. Review Data Anda</h3>
                            <div class="bg-gray-50 p-6 rounded text-sm space-y-4 shadow-inner border border-stone-100">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-xs text-gray-500 uppercase font-bold tracking-wider">Informasi Pribadi</p>
                                        <p class="mt-1"><strong>Nama:</strong> <span x-text="formData.full_name"></span></p>
                                        <p><strong>No HP:</strong> <span x-text="formData.phone_number"></span></p>
                                        <p><strong>Gender:</strong> <span x-text="formData.gender === 'male' ? 'Laki-laki' : 'Perempuan'"></span></p>
                                        <p><strong>Tgl Lahir:</strong> <span x-text="formData.birth_date"></span></p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 uppercase font-bold tracking-wider">Lokasi & Area</p>
                                        <p class="mt-1"><strong>Alamat:</strong> <span x-text="formData.address"></span></p>
                                        <p><strong>Kota:</strong> <span x-text="formData.city"></span></p>
                                        <p><strong>Area Pilihan:</strong> <span x-text="getSelectedAreaName()" class="text-tumbas font-bold"></span></p>
                                    </div>
                                </div>
                                <hr>
                                <div>
                                    <p class="text-xs text-gray-400 font-extrabold uppercase tracking-widest mb-3">Pengalaman Kerja</p>
                                    <div class="space-y-2">
                                        <template x-for="(exp, i) in experiences" :key="i">
                                            <div class="bg-white p-3 rounded-xl border border-stone-200 flex items-center justify-between">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-8 h-8 rounded-lg bg-stone-100 flex items-center justify-center text-stone-500 font-black text-xs" x-text="i+1"></div>
                                                    <div>
                                                        <p class="font-bold text-gray-800" x-text="exp.company_name"></p>
                                                        <p class="text-[10px] text-gray-400 font-bold uppercase" x-text="exp.position || '-'"></p>
                                                    </div>
                                                </div>
                                                <div class="text-[10px] font-black text-tumbas bg-orange-50 px-2 py-1 rounded border border-orange-100 uppercase tracking-tighter">
                                                    <span x-text="formatDate(exp.start_date)"></span> - <span x-text="formatDate(exp.end_date)"></span>
                                                </div>
                                            </div>
                                        </template>
                                        <template x-if="experiences.length === 0">
                                            <p class="text-sm text-gray-400 italic">Tidak ada pengalaman yang ditambahkan.</p>
                                        </template>
                                    </div>
                                </div>
                                <hr>
                                <div>
                                    <p class="text-xs text-gray-500 uppercase font-bold tracking-wider">Dokumen</p>
                                    <p class="mt-1 text-green-600 font-semibold italic">✓ CV dan Pas Foto siap dikirim.</p>
                                </div>
                            </div>

                            <div class="mt-6 flex justify-between">
                                <button type="button" @click="step--" class="bg-stone-200 hover:bg-stone-300 text-gray-700 font-bold px-6 py-2 rounded-full transition">Kembali</button>
                                <button type="button" @click="submitForm()" class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 font-extrabold text-white px-8 py-3 rounded-full shadow-xl transform transition-transform hover:-translate-y-1">KIRIM PENDAFTARAN</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/18.1.5/js/intlTelInput.min.js"></script>
    <script>
        function registrationForm() {
            return {
                step: {{ $errors->any() ? (
                    $errors->hasAny(['full_name', 'phone_number', 'birth_date', 'gender']) ? 1 : (
                    $errors->hasAny(['address', 'city', 'selected_area_id']) ? 2 : (
                    $errors->has('experiences.*') ? 3 : (
                    $errors->hasAny(['cv', 'photo']) ? 4 : 5
                )))) : request()->get('step', 1) }},
                areas: @json($areas),
                formData: {
                    full_name: @json(old('full_name', '')),
                    phone_number: @json(old('phone_number', '')),
                    birth_date: @json(old('birth_date', '')),
                    gender: @json(old('gender', '')),
                    address: @json(old('address', '')),
                    city: @json(old('city', '')),
                    selected_area_id: @json(old('selected_area_id', '')),
                },
                experiences: Array.isArray(@json(old('experiences'))) ? @json(old('experiences')) : Object.values(@json(old('experiences', []))),
                cvFileName: null,
                photoPreview: null,
                errors: @json($errors->toArray()),
                iti: null,

                init() {
                    const input = document.querySelector("#phone_number_input");
                    if (input) {
                        if (this.formData.phone_number) {
                            input.value = this.formData.phone_number;
                        }
                        this.iti = window.intlTelInput(input, {
                            initialCountry: "id",
                            onlyCountries: ["id"],
                            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/18.1.5/js/utils.js",
                        });
                    }

                    // Clean experience dates from ISO to YYYY-MM-DD
                    this.experiences.forEach(exp => {
                        if (exp.start_date && exp.start_date.includes('T')) exp.start_date = exp.start_date.split('T')[0];
                        if (exp.end_date && exp.end_date.includes('T')) exp.end_date = exp.end_date.split('T')[0];
                    });
                },

                formatDate(dateStr) {
                    if (!dateStr) return 'Sekarang';
                    const date = new Date(dateStr);
                    if (isNaN(date)) return dateStr; // Return as is if invalid
                    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
                    return months[date.getMonth()] + ' ' + date.getFullYear();
                },

                addExperience() {
                    if (this.experiences.length < 3) {
                        this.experiences.push({ company_name: '', position: '', start_date: '', end_date: '' });
                    }
                },
                removeExperience(index) {
                    this.experiences.splice(index, 1);
                },

                handleCvUpload(e) {
                    const file = e.target.files[0];
                    if(file) {
                        this.cvFileName = file.name;
                    } else {
                        this.cvFileName = null;
                    }
                },
                handlePhotoUpload(e) {
                    const file = e.target.files[0];
                    if(file) {
                        this.photoPreview = URL.createObjectURL(file);
                    }
                },

                getSelectedAreaName() {
                    const area = this.areas.find(a => a.id == this.formData.selected_area_id);
                    return area ? area.name : 'Belum memilih';
                },

                validateStep1() {
                    this.errors = {};
                    if(!this.formData.full_name) this.errors.full_name = ['Nama lengkap wajib diisi'];
                    
                    if(!this.iti || !this.iti.isValidNumber()) {
                        this.errors.phone_number = ['Nomor HP tidak valid'];
                    } else {
                        this.formData.phone_number = this.iti.getNumber();
                    }
                    
                    if(!this.formData.birth_date) {
                        this.errors.birth_date = ['Tanggal lahir wajib diisi'];
                    } else {
                        const birthDate = new Date(this.formData.birth_date);
                        const today = new Date();
                        today.setHours(0, 0, 0, 0);
                        if (birthDate >= today) {
                            this.errors.birth_date = ['Tanggal lahir harus sebelum hari ini'];
                        }
                    }

                    if(!this.formData.gender) this.errors.gender = ['Gender wajib dipilih'];
                    
                    if(Object.keys(this.errors).length === 0) {
                        this.step = 2;
                    }
                },

                validateStep2() {
                    this.errors = {};
                    if(!this.formData.address) this.errors.address = ['Alamat lengkap wajib diisi'];
                    if(!this.formData.city) this.errors.city = ['Kota domisili wajib diisi'];
                    if(!this.formData.selected_area_id) this.errors.selected_area_id = ['Pilih salah satu area penempatan'];
                    
                    if(Object.keys(this.errors).length === 0) {
                        this.step = 3;
                    }
                },

                validateStep3() {
                    this.errors = {};
                    let hasExpError = false;
                    this.experiences.forEach((exp, index) => {
                        if (exp.company_name || exp.position || exp.start_date || exp.end_date) {
                            if (!exp.company_name) {
                                this.errors[`experiences.${index}.company_name`] = ['Nama perusahaan wajib diisi'];
                                hasExpError = true;
                            }
                            if (!exp.start_date) {
                                this.errors[`experiences.${index}.start_date`] = ['Tanggal mulai wajib diisi'];
                                hasExpError = true;
                            }
                            if (exp.start_date && exp.end_date && exp.end_date < exp.start_date) {
                                this.errors[`experiences.${index}.end_date`] = ['Tanggal selesai tidak boleh sebelum mulai'];
                                hasExpError = true;
                            }
                        }
                    });

                    if(!hasExpError) {
                        this.step = 4;
                    }
                },

                validateStep4() {
                    this.errors = {};
                    const cvFile = this.$refs.cv_input.files[0];
                    const photoFile = this.$refs.photo_input.files[0];

                    if(!cvFile) {
                        this.errors.cv = ['CV wajib diunggah (format PDF)'];
                    } else {
                        if (cvFile.type !== 'application/pdf') this.errors.cv = ['File CV harus berformat PDF'];
                        if (cvFile.size > 5 * 1024 * 1024) this.errors.cv = ['Ukuran file CV maksimal 5MB'];
                    }

                    if(!photoFile) {
                        this.errors.photo = ['Pas foto wajib diunggah'];
                    } else {
                        const validPhotoTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                        if (!validPhotoTypes.includes(photoFile.type)) this.errors.photo = ['Foto harus berformat JPG atau PNG'];
                        if (photoFile.size > 1024 * 1024) this.errors.photo = ['Ukuran foto maksimal 1MB'];
                    }
                    
                    if(Object.keys(this.errors).length === 0) {
                        this.step = 5;
                    }
                },

                submitForm() {
                    this.$refs.form.submit();
                }
            }
        }
    </script>
</x-app-layout>
