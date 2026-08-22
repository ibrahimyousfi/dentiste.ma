<x-app-layout>
    <x-slot name="header_title">
        <div class="flex items-center gap-3">
            <a href="{{ route('patients.index') }}" class="p-1.5 text-gray-400 hover:text-[#39D3C4] transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div class="h-9 w-9 rounded-xl bg-gradient-to-br from-[#39D3C4]/20 to-blue-500/20 flex items-center justify-center text-gray-700 font-bold text-sm shrink-0">
                {{ substr($patient->first_name, 0, 1) }}{{ substr($patient->last_name, 0, 1) }}
            </div>
            <div>
                <p class="font-extrabold text-gray-900 text-sm leading-none">{{ $patient->first_name }} {{ $patient->last_name }}</p>
                <div class="flex items-center gap-3 mt-0.5">
                    <span class="text-xs font-bold text-[#39D3C4]">PT-{{ str_pad($patient->id, 5, '0', STR_PAD_LEFT) }}</span>
                    <span class="text-xs text-gray-400">{{ $patient->phone ?? '' }}</span>
                </div>
            </div>
        </div>
    </x-slot>
    <div class="py-4 animate-fade-in" x-data="{ tab: window.location.hash ? window.location.hash.substring(1) : 'overview', chartOpen: false }" x-init="$watch('tab', value => window.history.replaceState(null, null, '#' + value))">
        <div class="w-full px-2">

            <!-- Tabs Navigation -->
            <div class="mb-6 bg-white p-2 rounded-2xl shadow-sm border border-gray-100 flex space-x-2 overflow-x-auto">
                <button @click="tab = 'overview'" :class="{ 'bg-[#39D3C4]/10 text-[#2db3a6] font-bold': tab === 'overview', 'text-gray-500 hover:bg-gray-50 font-medium': tab !== 'overview' }" class="px-5 py-2.5 rounded-xl text-sm transition-all whitespace-nowrap flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Overview
                </button>
                <button @click="tab = 'details'" :class="{ 'bg-[#39D3C4]/10 text-[#2db3a6] font-bold': tab === 'details', 'text-gray-500 hover:bg-gray-50 font-medium': tab !== 'details' }" class="px-5 py-2.5 rounded-xl text-sm transition-all whitespace-nowrap flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Patient Details
                </button>
                <button @click="tab = 'medical'" :class="{ 'bg-[#39D3C4]/10 text-[#2db3a6] font-bold': tab === 'medical', 'text-gray-500 hover:bg-gray-50 font-medium': tab !== 'medical' }" class="px-5 py-2.5 rounded-xl text-sm transition-all whitespace-nowrap flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Medical History
                </button>
                <button @click="tab = 'notes'" :class="{ 'bg-[#39D3C4]/10 text-[#2db3a6] font-bold': tab === 'notes', 'text-gray-500 hover:bg-gray-50 font-medium': tab !== 'notes' }" class="px-5 py-2.5 rounded-xl text-sm transition-all whitespace-nowrap flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path></svg>
                    Clinical Notes (AI)
                </button>
                <button @click="tab = 'media'" :class="{ 'bg-[#39D3C4]/10 text-[#2db3a6] font-bold': tab === 'media', 'text-gray-500 hover:bg-gray-50 font-medium': tab !== 'media' }" class="px-5 py-2.5 rounded-xl text-sm transition-all whitespace-nowrap flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    X-Rays & Media
                </button>
                <button @click="tab = 'finances'" :class="{ 'bg-yellow-400/10 text-yellow-600 font-bold': tab === 'finances', 'text-gray-500 hover:bg-gray-50 font-medium': tab !== 'finances' }" class="px-5 py-2.5 rounded-xl text-sm transition-all whitespace-nowrap flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Finances
                </button>
            </div>

            <!-- Tab Contents -->
            <div class="space-y-6">
                <!-- Patient Details Tab -->
                <div x-show="tab === 'details'" style="display: none;" x-transition.opacity.duration.300ms class="w-full">
                    <!-- Patient Info Card (Inline Edit Form) -->
                    <form action="{{ route('patients.update', $patient) }}" method="POST"
                          class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col h-full hover:shadow-md transition-shadow relative overflow-hidden">
                        @csrf
                        @method('PUT')
                        <div class="absolute top-0 right-0 w-32 h-32 bg-gray-50 rounded-bl-full -z-10"></div>
                        <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-100">
                            <h3 class="text-lg font-bold text-gray-900">Patient Details</h3>
                            <button type="submit" class="inline-flex items-center text-xs font-bold text-white bg-[#39D3C4] hover:bg-[#2db3a6] px-3 py-1.5 rounded-lg transition-colors">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Save
                            </button>
                        </div>
                        <div class="space-y-4 text-sm flex-1">
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1 block">First Name</label>
                                    <input type="text" name="first_name" value="{{ old('first_name', $patient->first_name) }}" required
                                           class="w-full rounded-lg border-gray-200 bg-gray-50 text-gray-900 text-sm focus:ring-[#39D3C4] focus:border-[#39D3C4] py-2">
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1 block">Last Name</label>
                                    <input type="text" name="last_name" value="{{ old('last_name', $patient->last_name) }}" required
                                           class="w-full rounded-lg border-gray-200 bg-gray-50 text-gray-900 text-sm focus:ring-[#39D3C4] focus:border-[#39D3C4] py-2">
                                </div>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1 block">Phone</label>
                                <input type="text" name="phone" value="{{ old('phone', $patient->phone) }}" required
                                       class="w-full rounded-lg border-gray-200 bg-gray-50 text-gray-900 text-sm focus:ring-[#39D3C4] focus:border-[#39D3C4] py-2">
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1 block">Date of Birth</label>
                                    <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $patient->date_of_birth ? \Carbon\Carbon::parse($patient->date_of_birth)->format('Y-m-d') : '') }}"
                                           class="w-full rounded-lg border-gray-200 bg-gray-50 text-gray-900 text-sm focus:ring-[#39D3C4] focus:border-[#39D3C4] py-2">
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1 block">Gender</label>
                                    <select name="gender" class="w-full rounded-lg border-gray-200 bg-gray-50 text-gray-900 text-sm focus:ring-[#39D3C4] focus:border-[#39D3C4] py-2">
                                        <option value="">—</option>
                                        <option value="male" @selected(old('gender', $patient->gender) == 'male')>Male</option>
                                        <option value="female" @selected(old('gender', $patient->gender) == 'female')>Female</option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1 block">National ID</label>
                                <input type="text" name="national_id" value="{{ old('national_id', $patient->national_id) }}"
                                       class="w-full rounded-lg border-gray-200 bg-gray-50 text-gray-900 text-sm focus:ring-[#39D3C4] focus:border-[#39D3C4] py-2">
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1 block">Email</label>
                                <input type="email" name="email" value="{{ old('email', $patient->email) }}"
                                       class="w-full rounded-lg border-gray-200 bg-gray-50 text-gray-900 text-sm focus:ring-[#39D3C4] focus:border-[#39D3C4] py-2">
                            </div>
                            <div class="pt-2 border-t border-gray-100">
                                <label class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1 block">Address</label>
                                <textarea name="address" rows="2"
                                          class="w-full rounded-lg border-gray-200 bg-gray-50 text-gray-900 text-sm focus:ring-[#39D3C4] focus:border-[#39D3C4] resize-none">{{ old('address', $patient->address) }}</textarea>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Overview Tab -->
                <div x-show="tab === 'overview'" x-transition.opacity.duration.300ms class="w-full">
                    <!-- Dental Chart (Inline) -->
                    <div class="w-full"
                         x-data="odontogram()"
                         @save-odontogram.window="saveChart()"
                         @print-chart.window="printChart()">
                        @include('patients.partials.odontogram-screen')
                        @include('patients.partials.odontogram-print')
                    </div>

                    @push('head_scripts')
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
                    <script src="https://unpkg.com/three@0.128.0/examples/js/controls/OrbitControls.js"></script>
                    @endpush

                    @push('scripts')
                    <script>
                        document.addEventListener('alpine:init', () => {
                            Alpine.data('odontogram', () => {
                                const threeCtx = { scene: null, camera: null, renderer: null, controls: null, teethMeshMap: {}, raycaster: null, mouse: null, animationId: null };
                                return {
                                viewMode: '2D', // '2D' or '3D'
                                activeTool: 'eraser',
                                treatmentCatalogs: @json($treatmentCatalogs),
                                chartData: {},
                                isSaving: false,
                                isChild: @json($isChild),
                                canEditChart: @json(auth()->user()->hasRole('Clinic Owner')),
                                
                                // 3D Engine state moved to threeCtx

                                findings: @json($findings),

                                init() {
                                    // Initialise Three.js helpers (must be done after THREE is loaded)
                                    threeCtx.raycaster = new THREE.Raycaster();
                                    threeCtx.mouse     = new THREE.Vector2();

                                    const allTeeth = [
                                        18,17,16,15,14,13,12,11, 21,22,23,24,25,26,27,28,
                                        48,47,46,45,44,43,42,41, 31,32,33,34,35,36,37,38,
                                        55,54,53,52,51, 61,62,63,64,65,
                                        85,84,83,82,81, 71,72,73,74,75
                                    ];
                                    allTeeth.forEach(t => {
                                        this.chartData[t] = { status: 'healthy', surfaces: { T: 'healthy', R: 'healthy', B: 'healthy', L: 'healthy', C: 'healthy' }, treatments: [], received: 0 };
                                    });
                                    if (this.findings && this.findings.length > 0) {
                                        this.findings.forEach(f => {
                                            if (this.chartData[f.tooth_number]) {
                                                this.chartData[f.tooth_number].status = f.status;
                                                if (f.surfaces) this.chartData[f.tooth_number].surfaces = f.surfaces;
                                                if (f.treatments && Array.isArray(f.treatments) && f.treatments.length > 0) {
                                                    this.chartData[f.tooth_number].treatments = f.treatments;
                                                } else {
                                                    let price = f.price ? parseFloat(f.price) : 0;
                                                    if (price > 0) this.chartData[f.tooth_number].treatments.push({ id: null, name: 'Legacy Treatment', price });
                                                }
                                                this.chartData[f.tooth_number].received = f.received !== undefined ? parseFloat(f.received) : 0;
                                            }
                                        });
                                    }
                                    window.addEventListener('save-odontogram', () => this.saveChart());
                                    window.addEventListener('print-chart', () => this.printChart());

                                    // Listen for viewMode changes to initialize 3D
                                    this.$watch('viewMode', (value) => {
                                        if (value === '3D') {
                                            this.$nextTick(() => {
                                                // Small delay so browser applies display:block before Three.js reads dimensions
                                                setTimeout(() => {
                                                    if (!threeCtx.scene) {
                                                        this.init3DScene();
                                                        this.buildArch3D();
                                                        this.add3DEvents();
                                                        this.animate();
                                                    } else {
                                                        this.update3DFromData();
                                                        // Resize renderer in case container changed size
                                                        const container = document.getElementById('three-canvas-container');
                                                        if (container && container.clientWidth > 0) {
                                                            threeCtx.camera.aspect = container.clientWidth / container.clientHeight;
                                                            threeCtx.camera.updateProjectionMatrix();
                                                            threeCtx.renderer.setSize(container.clientWidth, container.clientHeight);
                                                        }
                                                    }
                                                }, 50);
                                            });
                                        }
                                    });
                                },

                                // --- 3D ENGINE METHODS ---
                                init3DScene() {
                                    const container = document.getElementById('three-canvas-container');
                                    if (!container) return;

                                    const w = container.clientWidth  || container.offsetWidth  || 900;
                                    const h = container.clientHeight || container.offsetHeight || 600;

                                    threeCtx.scene = new THREE.Scene();
                                    threeCtx.scene.background = new THREE.Color(0x0f172a); // deep navy
                                    threeCtx.scene.fog = new THREE.Fog(0x0f172a, 20, 60);

                                    threeCtx.camera = new THREE.PerspectiveCamera(45, w / h, 0.1, 200);
                                    threeCtx.camera.position.set(0, 18, 25);

                                    threeCtx.renderer = new THREE.WebGLRenderer({ antialias: true, alpha: false });
                                    threeCtx.renderer.setSize(w, h);
                                    threeCtx.renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
                                    threeCtx.renderer.shadowMap.enabled = true;
                                    threeCtx.renderer.shadowMap.type = THREE.PCFSoftShadowMap;
                                    threeCtx.renderer.outputEncoding = THREE.sRGBEncoding;
                                    threeCtx.renderer.toneMapping = THREE.ACESFilmicToneMapping;
                                    
                                    container.innerHTML = '';
                                    container.appendChild(threeCtx.renderer.domElement);

                                    // --- Orbit Controls ---
                                    if (typeof THREE.OrbitControls !== 'undefined') {
                                        threeCtx.controls = new THREE.OrbitControls(threeCtx.camera, threeCtx.renderer.domElement);
                                        threeCtx.controls.enableDamping = true;
                                        threeCtx.controls.dampingFactor = 0.05;
                                        threeCtx.controls.maxPolarAngle = Math.PI / 1.8;
                                        threeCtx.controls.minDistance = 10;
                                        threeCtx.controls.maxDistance = 40;
                                        threeCtx.controls.target.set(0, 0, 0);
                                    }

                                    // --- Resize ---
                                    window.addEventListener('resize', () => {
                                        const cw = container.clientWidth || 900;
                                        const ch = container.clientHeight || 600;
                                        if (cw > 0 && ch > 0) {
                                            threeCtx.camera.aspect = cw / ch;
                                            threeCtx.camera.updateProjectionMatrix();
                                            threeCtx.renderer.setSize(cw, ch);
                                        }
                                    });

                                    // --- Advanced Lighting ---
                                    const ambientLight = new THREE.AmbientLight(0xffffff, 0.4);
                                    threeCtx.scene.add(ambientLight);

                                    const mainLight = new THREE.DirectionalLight(0xffffff, 1.2);
                                    mainLight.position.set(10, 20, 15);
                                    mainLight.castShadow = true;
                                    mainLight.shadow.mapSize.width = 2048;
                                    mainLight.shadow.mapSize.height = 2048;
                                    mainLight.shadow.bias = -0.001;
                                    threeCtx.scene.add(mainLight);

                                    const fillLight = new THREE.DirectionalLight(0x93c5fd, 0.6); // slight blue tint
                                    fillLight.position.set(-10, 5, -15);
                                    threeCtx.scene.add(fillLight);
                                    
                                    const pointLight = new THREE.PointLight(0xfff0dd, 0.5, 50); // warm light from below
                                    pointLight.position.set(0, -5, 5);
                                    threeCtx.scene.add(pointLight);
                                },

                                createProceduralTooth(type) {
                                    const shape = new THREE.Shape();
                                    const extrudeSettings = { 
                                        depth: 1.5, 
                                        bevelEnabled: true, 
                                        bevelSegments: 5, 
                                        steps: 2, 
                                        bevelSize: 0.2, 
                                        bevelThickness: 0.3 
                                    };

                                    if (type === 'incisor') {
                                        shape.moveTo(-0.4, -0.2); shape.lineTo(0.4, -0.2); 
                                        shape.quadraticCurveTo(0.6, 0.5, 0.5, 1.2); 
                                        shape.quadraticCurveTo(0, 1.4, -0.5, 1.2); 
                                        shape.quadraticCurveTo(-0.6, 0.5, -0.4, -0.2);
                                        extrudeSettings.depth = 0.5;
                                        extrudeSettings.bevelSize = 0.1;
                                        extrudeSettings.bevelThickness = 0.2;
                                    } else if (type === 'canine') {
                                        shape.moveTo(-0.4, -0.2); shape.lineTo(0.4, -0.2); 
                                        shape.quadraticCurveTo(0.6, 0.6, 0.5, 1.0); 
                                        shape.lineTo(0, 1.5); 
                                        shape.lineTo(-0.5, 1.0); 
                                        shape.quadraticCurveTo(-0.6, 0.6, -0.4, -0.2);
                                        extrudeSettings.depth = 0.6;
                                        extrudeSettings.bevelSize = 0.15;
                                    } else if (type === 'premolar') {
                                        shape.moveTo(-0.6, -0.3); shape.lineTo(0.6, -0.3); 
                                        shape.quadraticCurveTo(0.8, 0.4, 0.7, 0.8); 
                                        shape.lineTo(0, 1.2); 
                                        shape.lineTo(-0.7, 0.8); 
                                        shape.quadraticCurveTo(-0.8, 0.4, -0.6, -0.3);
                                        extrudeSettings.depth = 0.9;
                                    } else { // molar
                                        shape.moveTo(-0.8, -0.5); shape.lineTo(0.8, -0.5); 
                                        shape.quadraticCurveTo(1.0, 0.2, 0.9, 0.6); 
                                        shape.lineTo(0.5, 1.0); shape.lineTo(0, 0.8); 
                                        shape.lineTo(-0.5, 1.0); shape.lineTo(-0.9, 0.6); 
                                        shape.quadraticCurveTo(-1.0, 0.2, -0.8, -0.5);
                                        extrudeSettings.depth = 1.2;
                                    }

                                    const geo = new THREE.ExtrudeGeometry(shape, extrudeSettings);
                                    geo.center(); 
                                    geo.computeVertexNormals();
                                    return geo;
                                },

                                buildArch3D() {
                                    // Gum base
                                    const gumMat = new THREE.MeshStandardMaterial({ 
                                        color: 0xcc7a75, 
                                        roughness: 0.4,
                                        metalness: 0.1
                                    });

                                    // Upper arch gum
                                    const upperGumGeo = new THREE.TorusGeometry(7, 1.2, 16, 100, Math.PI);
                                    const upperGum = new THREE.Mesh(upperGumGeo, gumMat);
                                    upperGum.rotation.x = Math.PI / 2;
                                    upperGum.position.set(0, 1.5, 0);
                                    upperGum.receiveShadow = true;
                                    threeCtx.scene.add(upperGum);

                                    // Lower arch gum
                                    const lowerGum = new THREE.Mesh(upperGumGeo, gumMat.clone());
                                    lowerGum.rotation.x = Math.PI / 2;
                                    lowerGum.rotation.z = Math.PI;
                                    lowerGum.position.set(0, -1.5, 0);
                                    lowerGum.receiveShadow = true;
                                    threeCtx.scene.add(lowerGum);

                                    // Highly realistic tooth material using PhysicalMaterial
                                    const toothMat = new THREE.MeshPhysicalMaterial({
                                        color: 0xffffff,
                                        roughness: 0.15,
                                        metalness: 0.05,
                                        clearcoat: 0.8,
                                        clearcoatRoughness: 0.1,
                                        transmission: 0.1, // slightly translucent
                                        thickness: 1.0, // for volume
                                    });

                                    const toothTypes = ['incisor','incisor','canine','premolar','premolar','molar','molar','molar'];
                                    const quadrants = [
                                        { start: 11, dir: 1,  y:  2.3, sign: -1 }, // upper-right
                                        { start: 21, dir: 1,  y:  2.3, sign:  1 }, // upper-left
                                        { start: 41, dir: 1,  y: -2.3, sign: -1 }, // lower-right
                                        { start: 31, dir: 1,  y: -2.3, sign:  1 }, // lower-left
                                    ];

                                    quadrants.forEach(q => {
                                        for (let i = 0; i < 8; i++) {
                                            const toothNum = q.start + i;
                                            const type = toothTypes[i];

                                            const angle = (i / 8) * (Math.PI / 2) + 0.05;
                                            const archRadius = 5.5 + i * 0.35; 
                                            const x = q.sign * Math.sin(angle) * archRadius;
                                            const z = -Math.cos(angle) * archRadius + 3;

                                            const geo  = this.createProceduralTooth(type);
                                            const mat  = toothMat.clone();
                                            const mesh = new THREE.Mesh(geo, mat);

                                            mesh.position.set(x, q.y, z);
                                            
                                            // Adjust rotation so teeth face outward nicely
                                            mesh.rotation.y = q.sign * angle;
                                            // Tilt tooth outward/inward
                                            if (q.y > 0) mesh.rotation.x = Math.PI; // flip upper teeth
                                            mesh.rotation.z = q.sign * angle * 0.1;
                                            
                                            mesh.castShadow = true;
                                            mesh.receiveShadow = true;
                                            mesh.userData = { toothNumber: toothNum };

                                            threeCtx.scene.add(mesh);
                                            threeCtx.teethMeshMap[toothNum] = mesh;
                                        }
                                    });

                                    this.update3DFromData();
                                },

                                update3DFromData() {
                                    Object.keys(threeCtx.teethMeshMap).forEach(num => {
                                        const mesh = threeCtx.teethMeshMap[num];
                                        const data = this.chartData[num];
                                        if (!data) return;

                                        if (data.status === 'extracted') {
                                            mesh.visible = false;
                                        } else {
                                            mesh.visible = true;
                                            // Reset to realistic ivory white
                                            mesh.material.color.setHex(0xfcf8f2);
                                            mesh.material.emissive.setHex(0x000000);
                                            mesh.material.metalness = 0.05;
                                            mesh.material.roughness = 0.15;

                                            const hasDecay = Object.values(data.surfaces).includes('decayed') || data.status === 'decayed';
                                            const hasFill  = Object.values(data.surfaces).includes('filled')  || data.status === 'filled';
                                            const hasCrown = data.status === 'crown';

                                            if (hasCrown) {
                                                mesh.material.color.setHex(0xffd700); // Gold
                                                mesh.material.metalness = 1.0;
                                                mesh.material.roughness = 0.2;
                                            }
                                            else if (hasDecay) mesh.material.color.setHex(0x5c4033); // Dark brown/black for decay
                                            else if (hasFill)  mesh.material.color.setHex(0xa0aab5); // Silver/Amalgam fill
                                        }
                                    });
                                },

                                add3DEvents() {
                                    // Click-to-apply raycasting on the renderer canvas
                                    const canvas = threeCtx.renderer.domElement;
                                    canvas.addEventListener('click', (event) => {
                                        if (!this.canEditChart || !this.activeTool || this.activeTool === 'eraser') return;
                                        const rect = canvas.getBoundingClientRect();
                                        const mx = ((event.clientX - rect.left) / rect.width)  * 2 - 1;
                                        const my = -((event.clientY - rect.top)  / rect.height) * 2 + 1;
                                        threeCtx.mouse.set(mx, my);
                                        threeCtx.raycaster.setFromCamera(threeCtx.mouse, threeCtx.camera);
                                        const intersects = threeCtx.raycaster.intersectObjects(Object.values(threeCtx.teethMeshMap));
                                        if (intersects.length > 0) {
                                            const num = intersects[0].object.userData.toothNumber;
                                            this.applyTool(num, 'C');
                                            
                                            // Visual feedback on click
                                            intersects[0].object.material.emissive.setHex(0x39D3C4);
                                            setTimeout(() => this.update3DFromData(), 200);
                                            this.update3DFromData();
                                        }
                                    });
                                },

                                animate() {
                                    threeCtx.animationId = requestAnimationFrame(() => this.animate());
                                    if (threeCtx.controls) threeCtx.controls.update();
                                    if (threeCtx.renderer && threeCtx.scene && threeCtx.camera) {
                                        threeCtx.renderer.render(threeCtx.scene, threeCtx.camera);
                                    }
                                },

                                applyTool(tooth, surface = null) {
                                    if (!this.canEditChart || !this.activeTool) return;
                                    if (this.activeTool.startsWith('treatment_')) {
                                        let catalogId = this.activeTool.split('_')[1];
                                        let item = this.treatmentCatalogs.find(t => t.id == catalogId);
                                        if (item) this.chartData[tooth].treatments.push({ id: item.id, name: item.name, price: parseFloat(item.default_price) });
                                    } else {
                                        if (this.activeTool === 'eraser') {
                                            if (surface) { this.chartData[tooth].surfaces[surface] = 'healthy'; }
                                            else { this.chartData[tooth].status = 'healthy'; this.chartData[tooth].surfaces = { T: 'healthy', R: 'healthy', B: 'healthy', L: 'healthy', C: 'healthy' }; }
                                        } else if (this.activeTool === 'extracted') { this.chartData[tooth].status = 'extracted'; }
                                        else if (this.activeTool === 'crown') { this.chartData[tooth].status = 'crown'; }
                                        else if (['decayed', 'filled'].includes(this.activeTool)) {
                                            if (surface) { this.chartData[tooth].surfaces[surface] = this.activeTool; if (this.chartData[tooth].status === 'extracted') this.chartData[tooth].status = 'healthy'; }
                                            else { this.chartData[tooth].status = this.activeTool; }
                                        }
                                    }
                                },

                                isToothAffected(tooth) {
                                    if (!this.chartData[tooth]) return false;
                                    let d = this.chartData[tooth];
                                    if (d.status !== 'healthy') return true;
                                    if (d.treatments.length > 0) return true;
                                    return Object.values(d.surfaces).some(s => s !== 'healthy');
                                },

                                hasFindings() { return Object.keys(this.chartData).some(t => this.isToothAffected(t)); },

                                getTreatmentDescription(tooth) {
                                    let d = this.chartData[tooth]; if (!d) return '';
                                    let parts = [];
                                    if (d.status === 'extracted') parts.push('Extraction (Missing)');
                                    if (d.status === 'crown') parts.push('Crown / Bridge');
                                    if (d.status === 'decayed') parts.push('Decayed');
                                    for (let s in d.surfaces) { if (d.surfaces[s] === 'decayed') parts.push(`Caries (${s})`); if (d.surfaces[s] === 'filled') parts.push(`Filling (${s})`); }
                                    if (d.treatments) d.treatments.forEach(t => parts.push(t.name));
                                    return parts.join(', ');
                                },

                                calculateTotal() { let t = 0; for (const tooth in this.chartData) { if (this.isToothAffected(tooth)) this.chartData[tooth].treatments.forEach(tr => t += parseFloat(tr.price || 0)); } return t; },
                                calculateReceived() { let t = 0; for (const tooth in this.chartData) { if (this.isToothAffected(tooth)) t += parseFloat(this.chartData[tooth].received || 0); } return t; },

                                formatPrice(price) { return (parseFloat(price) || 0).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' DH'; },

                                getGroupedTreatments() {
                                    const groups = {};
                                    for (const tooth in this.chartData) {
                                        if (this.isToothAffected(tooth)) {
                                            let toothTotalPrice = 0;
                                            this.chartData[tooth].treatments.forEach(t => toothTotalPrice += parseFloat(t.price || 0));
                                            const desc = this.getTreatmentDescription(tooth) || 'Consultation / Diagnosis';
                                            if (!groups[desc]) groups[desc] = { description: desc, teeth: [], totalPrice: 0, totalReceived: 0 };
                                            groups[desc].teeth.push(tooth);
                                            groups[desc].totalPrice += toothTotalPrice;
                                            groups[desc].totalReceived += parseFloat(this.chartData[tooth].received || 0);
                                        }
                                    }
                                    return Object.values(groups);
                                },

                                getSurfaceColor(tooth, surface) {
                                    let d = this.chartData[tooth]; if (!d) return '#ffffff';
                                    if (d.status === 'extracted') return 'none';
                                    if (d.status === 'crown') return '#fef08a';
                                    let s = d.surfaces[surface];
                                    if (s === 'decayed') return '#ef4444';
                                    if (s === 'filled') return '#3b82f6';
                                    return '#ffffff';
                                },

                                getToothStroke(tooth) {
                                    let d = this.chartData[tooth]; if (!d) return '#d1d5db';
                                    if (d.status === 'extracted') return 'none';
                                    if (d.status === 'crown') return '#ca8a04';
                                    return '#9ca3af';
                                },

                                renderToothInteractive(tooth) {
                                    if (!tooth) return '';
                                    let d = this.chartData[tooth];
                                    let stroke = this.getToothStroke(tooth);
                                    let cT = this.getSurfaceColor(tooth, 'T'), cR = this.getSurfaceColor(tooth, 'R'), cB = this.getSurfaceColor(tooth, 'B'), cL = this.getSurfaceColor(tooth, 'L'), cC = this.getSurfaceColor(tooth, 'C');
                                    let isExtracted = d && d.status === 'extracted';
                                    let hasTreatments = d && d.treatments.length > 0;
                                    if (isExtracted) return `<svg viewBox="0 0 40 40" class="w-full h-full"><line x1="5" y1="5" x2="35" y2="35" stroke="#ef4444" stroke-width="3" stroke-linecap="round"/><line x1="35" y1="5" x2="5" y2="35" stroke="#ef4444" stroke-width="3" stroke-linecap="round"/></svg>`;
                                    return `<svg viewBox="0 0 40 40" class="w-full h-full" @click.stop="applyTool(${tooth})"><polygon points="20,2 38,20 20,38 2,20" fill="${cT}" stroke="${stroke}" stroke-width="1" @click.stop="applyTool(${tooth}, 'T')"/><polygon points="20,10 30,20 20,30 10,20" fill="${cC}" stroke="${stroke}" stroke-width="1" @click.stop="applyTool(${tooth}, 'C')"/><polygon points="38,20 30,20 20,30 20,38" fill="${cR}" stroke="${stroke}" stroke-width="1" @click.stop="applyTool(${tooth}, 'R')"/><polygon points="2,20 10,20 20,30 20,38" fill="${cL}" stroke="${stroke}" stroke-width="1" @click.stop="applyTool(${tooth}, 'L')"/>${hasTreatments ? '<circle cx="35" cy="5" r="5" fill="#8b5cf6"/>' : ''}</svg>`;
                                },

                                getArchStyle(tooth) {
                                    let t = parseInt(tooth), isUpper = false, isAdult = true, index = 0;
                                    if (t >= 11 && t <= 18) { isUpper = true; isAdult = true; index = t - 11; }
                                    if (t >= 21 && t <= 28) { isUpper = true; isAdult = true; index = t - 21; }
                                    if (t >= 41 && t <= 48) { isUpper = false; isAdult = true; index = t - 41; }
                                    if (t >= 31 && t <= 38) { isUpper = false; isAdult = true; index = t - 31; }
                                    if (t >= 51 && t <= 55) { isUpper = true; isAdult = false; index = t - 51; }
                                    if (t >= 61 && t <= 65) { isUpper = true; isAdult = false; index = t - 61; }
                                    if (t >= 81 && t <= 85) { isUpper = false; isAdult = false; index = t - 81; }
                                    if (t >= 71 && t <= 75) { isUpper = false; isAdult = false; index = t - 71; }
                                    let multY = isAdult ? 6.0 : 7.0, multX = isAdult ? 2.5 : 3.0;
                                    let y = Math.pow(index, 1.4) * multY, x = Math.pow(index, 1.2) * multX;
                                    let isLeftQuad = (t >= 11 && t <= 18) || (t >= 41 && t <= 48) || (t >= 51 && t <= 55) || (t >= 81 && t <= 85);
                                    if (isLeftQuad) x = -x;
                                    if (!isUpper) y = -y;
                                    return `transform: translate3d(${x}px, ${y}px, 0);`;
                                },

                                isUpperTooth(tooth) { let t = parseInt(tooth); return (t >= 11 && t <= 28) || (t >= 51 && t <= 65); },
                                isAdultTooth(tooth) { let t = parseInt(tooth); return (t >= 11 && t <= 48); },

                                async saveChart() {
                                    this.isSaving = true;
                                    try {
                                        const res = await fetch('{{ route("patients.dental-chart.store", $patient) }}', {
                                            method: 'POST',
                                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                                            body: JSON.stringify({ chartData: this.chartData })
                                        });
                                        const data = await res.json();
                                        if (data.success) { alert('Chart saved!'); }
                                    } catch (e) { alert('Error saving chart.'); }
                                    finally { this.isSaving = false; }
                                },

                                async generatePlan() {
                                    try {
                                        const res = await fetch('{{ route("patients.dental-chart.generate-plan", $patient) }}', {
                                            method: 'POST',
                                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                                            body: JSON.stringify({ chartData: this.chartData })
                                        });
                                        const data = await res.json();
                                        if (data.success && data.redirect_url) window.location = data.redirect_url;
                                        else alert(data.message || 'No treatments found.');
                                    } catch (e) { alert('Error generating plan.'); }
                                },

                                printChart() {
                                    const printElement = document.getElementById('print-area');
                                    if (!printElement) return;
                                    let styles = '';
                                    document.querySelectorAll('style, link[rel="stylesheet"]').forEach(n => styles += n.outerHTML);
                                    let oldIframe = document.getElementById('hidden-print-iframe');
                                    if (oldIframe) oldIframe.remove();
                                    const iframe = document.createElement('iframe');
                                    iframe.id = 'hidden-print-iframe';
                                    Object.assign(iframe.style, { position: 'absolute', width: '100vw', height: '100vh', left: '-9999px', top: '-9999px', border: 'none' });
                                    document.body.appendChild(iframe);
                                    const doc = iframe.contentWindow.document;
                                    doc.head.innerHTML = `<title>Dental Chart - {{ $patient->first_name }} {{ $patient->last_name }}</title>${styles}`;
                                    doc.body.innerHTML = '<div class="a5-container">' + printElement.innerHTML + '</div>';
                                    setTimeout(() => { iframe.contentWindow.focus(); iframe.contentWindow.print(); }, 1200);
                                },

                                getPrintArchStyle(tooth) {
                                    let t = parseInt(tooth), isUpper = false, isAdult = true, index = 0, isLeftQuad = false;
                                    if (t >= 11 && t <= 18) { isUpper = true; isAdult = true; index = t - 11; isLeftQuad = true; }
                                    if (t >= 21 && t <= 28) { isUpper = true; isAdult = true; index = t - 21; }
                                    if (t >= 41 && t <= 48) { isUpper = false; isAdult = true; index = t - 41; isLeftQuad = true; }
                                    if (t >= 31 && t <= 38) { isUpper = false; isAdult = true; index = t - 31; }
                                    if (t >= 51 && t <= 55) { isUpper = true; isAdult = false; index = t - 51; isLeftQuad = true; }
                                    if (t >= 61 && t <= 65) { isUpper = true; isAdult = false; index = t - 61; }
                                    if (t >= 81 && t <= 85) { isUpper = false; isAdult = false; index = t - 81; isLeftQuad = true; }
                                    if (t >= 71 && t <= 75) { isUpper = false; isAdult = false; index = t - 71; }
                                    let totalTeeth = isAdult ? 8.2 : 5.2;
                                    let angleRad = ((index + 0.5) / totalTeeth) * (Math.PI / 2);
                                    if (isLeftQuad) angleRad = -angleRad;
                                    let rx = isAdult ? 180 : 100, ry = isAdult ? 220 : 120;
                                    let x = Math.sin(angleRad) * rx, y = Math.cos(angleRad) * ry;
                                    if (isUpper) y = -y;
                                    let originY = isUpper ? -30 : 30; y += originY;
                                    return `position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%) translate(${x}px, ${y}px);`;
                                },

                                getPrintNumberStyle(tooth) {
                                    let t = parseInt(tooth), isUpper = false, isAdult = true, index = 0, isLeftQuad = false;
                                    if (t >= 11 && t <= 18) { isUpper = true; isAdult = true; index = t - 11; isLeftQuad = true; }
                                    if (t >= 21 && t <= 28) { isUpper = true; isAdult = true; index = t - 21; }
                                    if (t >= 41 && t <= 48) { isUpper = false; isAdult = true; index = t - 41; isLeftQuad = true; }
                                    if (t >= 31 && t <= 38) { isUpper = false; isAdult = true; index = t - 31; }
                                    if (t >= 51 && t <= 55) { isUpper = true; isAdult = false; index = t - 51; isLeftQuad = true; }
                                    if (t >= 61 && t <= 65) { isUpper = true; isAdult = false; index = t - 61; }
                                    if (t >= 81 && t <= 85) { isUpper = false; isAdult = false; index = t - 81; isLeftQuad = true; }
                                    if (t >= 71 && t <= 75) { isUpper = false; isAdult = false; index = t - 71; }
                                    let totalTeeth = isAdult ? 8.2 : 5.2;
                                    let angleRad = ((index + 0.5) / totalTeeth) * (Math.PI / 2);
                                    if (isLeftQuad) angleRad = -angleRad;
                                    let offset = isAdult ? 40 : 25;
                                    let rx = (isAdult ? 180 : 100) + offset, ry = (isAdult ? 220 : 120) + offset;
                                    let x = Math.sin(angleRad) * rx, y = Math.cos(angleRad) * ry;
                                    if (isUpper) y = -y;
                                    let originY = isUpper ? -30 : 30; y += originY;
                                    return `position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%) translate(${x}px, ${y}px);`;
                                }
                            };
                        });
                    });
                    </script>
                    @endpush
                </div>

                <!-- Medical History Tab -->
                <div x-show="tab === 'medical'" style="display: none;" x-transition.opacity.duration.300ms>
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                        <div class="flex justify-between items-center mb-8 pb-4 border-b border-gray-100">
                            <h3 class="text-xl font-extrabold text-gray-900 flex items-center">
                                <div class="p-2 bg-rose-50 rounded-xl mr-3">
                                    <svg class="w-6 h-6 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                </div>
                                Health Profile
                            </h3>
                            <button class="text-sm px-4 py-2 bg-gray-50 border border-gray-200 text-gray-700 rounded-xl font-bold hover:bg-gray-100 transition-colors flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                Edit Profile
                            </button>
                        </div>
                        
                        <!-- Temporary UI for Medical History Form -->
                        @include('patients.partials.medical-history-form')
                        
                    </div>
            </div>
            
            <!-- Clinical Notes Tab -->
            <div x-show="tab === 'notes'" style="display: none;" x-transition.opacity.duration.300ms>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                    <div class="flex justify-between items-center mb-8 pb-4 border-b border-gray-100">
                        <h3 class="text-xl font-extrabold text-gray-900 flex items-center">
                            <div class="p-2 bg-purple-50 rounded-xl mr-3">
                                <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </div>
                            Clinical Notes (AI Voice Dictation)
                        </h3>
                    </div>

                    <div x-data="voiceDictation()" class="space-y-6">
                        <!-- AI Dictation Form -->
                        <form action="{{ route('patients.notes.store', $patient) }}" method="POST" class="bg-gray-50 rounded-2xl p-6 border border-gray-100 relative shadow-inner">
                            @csrf
                            <div class="flex justify-between items-end mb-4">
                                <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider">New Note</label>
                                
                                <div class="flex space-x-2">
                                    <!-- Smart Templates -->
                                    <div class="relative" x-data="{ open: false }">
                                        <button @click.prevent="open = !open" type="button" class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-bold rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none">
                                            <svg class="mr-1.5 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                                            Templates
                                        </button>
                                        <div x-show="open" @click.away="open = false" style="display: none;" class="origin-top-right absolute right-0 mt-2 w-56 rounded-xl shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10 divide-y divide-gray-100">
                                            <a href="#" @click.prevent="insertTemplate('Patient attended for routine checkup. No pain reported. Soft tissues healthy.'); open = false" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#39D3C4] font-medium transition-colors">Standard Checkup</a>
                                            <a href="#" @click.prevent="insertTemplate('LA administered. Caries removed. Composite filling placed. Occlusion checked and adjusted. Post-op instructions given.'); open = false" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#39D3C4] font-medium transition-colors">Composite Filling</a>
                                            <a href="#" @click.prevent="insertTemplate('Patient presented with severe pain. X-ray taken. Root canal treatment commenced. Canals cleaned and shaped. Temporary dressing placed.'); open = false" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#39D3C4] font-medium transition-colors">Root Canal Prep</a>
                                        </div>
                                    </div>
                                    
                                    <!-- Language Selector removed (Whisper auto-detects) -->

                                    <!-- Voice Dictation Button -->
                                    <button @click.prevent="toggleRecording()" type="button" 
                                            :disabled="isProcessing"
                                            :class="isRecording ? 'bg-red-500 hover:bg-red-600 text-white border-transparent animate-pulse shadow-red-500/30 shadow-lg' : (isProcessing ? 'bg-gray-100 text-gray-400 cursor-not-allowed border-gray-200' : 'bg-white hover:bg-gray-50 text-gray-700 border-gray-300')"
                                            class="inline-flex items-center px-4 py-1.5 border shadow-sm text-xs font-bold rounded-lg transition-all focus:outline-none">
                                        <svg x-show="!isRecording && !isProcessing" class="mr-1.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path></svg>
                                        <svg x-show="isRecording && !isProcessing" style="display: none;" class="mr-1.5 h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8 7a1 1 0 00-1 1v4a1 1 0 102 0V8a1 1 0 00-1-1zm4 0a1 1 0 00-1 1v4a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                        <svg x-show="isProcessing" style="display: none;" class="animate-spin mr-1.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                        <span x-text="isRecording ? 'Stop Recording' : (isProcessing ? 'Processing AI...' : 'Start Dictation')"></span>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="relative">
                                <textarea x-ref="noteTextarea" x-model="noteContent" name="note" rows="5" :disabled="isProcessing" class="shadow-sm focus:ring-[#39D3C4] focus:border-[#39D3C4] block w-full sm:text-sm border-gray-200 rounded-xl bg-white p-4 font-medium text-gray-800 transition-colors disabled:opacity-50" placeholder="Start typing or click 'Start Dictation' to speak..."></textarea>
                            </div>
                            
                            <div class="mt-4 flex justify-end">
                                <button type="submit" class="inline-flex items-center px-6 py-2.5 border border-transparent text-sm font-bold rounded-xl shadow-sm text-white bg-[#39D3C4] hover:bg-[#2db3a6] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#39D3C4] transition-all">
                                    Save Note
                                </button>
                            </div>
                        </form>

                        <!-- Previous Notes History -->
                        <div class="mt-10">
                            <h4 class="text-sm font-black text-gray-900 uppercase tracking-wider mb-6 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Note History
                            </h4>
                            
                            <div class="space-y-6">
                                @forelse($patient->notes as $note)
                                    <div class="bg-white border-l-4 border-[#39D3C4] p-5 rounded-r-2xl shadow-sm relative group transition-all hover:shadow-md">
                                        <div class="flex justify-between items-start mb-2">
                                            <div class="flex items-center">
                                                <div class="h-8 w-8 rounded-full bg-gradient-to-r from-gray-200 to-gray-300 flex items-center justify-center text-xs font-bold text-gray-600 shadow-inner mr-3">
                                                    {{ substr($note->user->first_name ?? 'Dr', 0, 1) }}{{ substr($note->user->last_name ?? '', 0, 1) }}
                                                </div>
                                                <div>
                                                    <span class="text-sm font-bold text-gray-900">{{ $note->user->first_name ?? 'Doctor' }} {{ $note->user->last_name ?? '' }}</span>
                                                    <span class="text-xs text-gray-500 ml-2 font-medium">{{ $note->created_at->format('d M Y - H:i') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-gray-700 text-sm whitespace-pre-line leading-relaxed font-medium ml-11">
                                            {{ $note->note }}
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-12 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                                        <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        <p class="text-sm text-gray-500 font-medium">No clinical notes recorded yet.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- X-Rays & Media Tab -->
            <div x-show="tab === 'media'" style="display: none;" x-transition.opacity.duration.300ms>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8" x-data="xrayComparison()">
                    <div class="flex justify-between items-center mb-8 pb-4 border-b border-gray-100">
                        <h3 class="text-xl font-extrabold text-gray-900 flex items-center">
                            <div class="p-2 bg-blue-50 rounded-xl mr-3">
                                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            Advanced Digital Imaging
                        </h3>
                        <button @click="showUploadModal = true" class="text-sm px-4 py-2 bg-[#39D3C4] border border-transparent text-white rounded-xl font-bold hover:bg-[#2db3a6] transition-colors flex items-center shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Upload Image
                        </button>
                    </div>

                    <!-- Comparison Mode Toolbar -->
                    <div x-show="isComparing" style="display: none;" class="mb-6 bg-gradient-to-r from-gray-900 to-gray-800 rounded-2xl p-4 flex justify-between items-center shadow-lg text-white">
                        <div class="flex items-center space-x-3">
                            <span class="flex h-3 w-3">
                                <span class="animate-ping absolute inline-flex h-3 w-3 rounded-full bg-[#39D3C4] opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-[#39D3C4]"></span>
                            </span>
                            <span class="font-bold text-sm tracking-wide">Comparison Mode Active</span>
                        </div>
                        <div class="text-xs text-gray-300">
                            <span x-show="!selectedForCompare[0] || !selectedForCompare[1]">Select 2 images to compare</span>
                            <span x-show="selectedForCompare[0] && selectedForCompare[1]">Ready to compare</span>
                        </div>
                        <div class="space-x-2">
                            <button @click="openCompareView()" :disabled="!selectedForCompare[0] || !selectedForCompare[1]" :class="(selectedForCompare[0] && selectedForCompare[1]) ? 'bg-[#39D3C4] hover:bg-[#2db3a6] text-white' : 'bg-gray-700 text-gray-400 cursor-not-allowed'" class="px-4 py-1.5 rounded-lg text-xs font-bold transition-colors">
                                View Comparison
                            </button>
                            <button @click="toggleCompareMode()" class="px-3 py-1.5 bg-gray-700 hover:bg-gray-600 rounded-lg text-xs font-medium transition-colors">Cancel</button>
                        </div>
                    </div>

                    @if($patient->media->isEmpty())
                        <!-- Empty State -->
                        <div class="text-center py-16 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                            <svg class="mx-auto h-16 w-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <h3 class="text-lg font-bold text-gray-900 mb-1">No images found</h3>
                            <p class="text-sm text-gray-500 font-medium mb-6">Upload X-Rays, Scans or intraoral photos to build the patient's gallery.</p>
                            <button @click="showUploadModal = true" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-xl text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#39D3C4]">
                                Upload First Image
                            </button>
                        </div>
                    @else
                        <!-- Actions & Filters -->
                        <div class="flex justify-between items-center mb-6" x-show="!isComparing">
                            <div class="flex space-x-2">
                                <select class="text-sm border-gray-200 rounded-lg text-gray-600 focus:ring-[#39D3C4] focus:border-[#39D3C4]">
                                    <option>All Types</option>
                                    <option>X-Ray</option>
                                    <option>Scan</option>
                                    <option>Intraoral Photo</option>
                                </select>
                            </div>
                            <button @click="toggleCompareMode()" class="flex items-center px-4 py-2 text-sm font-bold text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                                Compare Side-by-Side
                            </button>
                        </div>

                        <!-- Gallery Grid -->
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            @foreach($patient->media as $media)
                                <div class="group relative rounded-2xl overflow-hidden bg-gray-100 aspect-square shadow-sm hover:shadow-md transition-all border border-gray-200"
                                     :class="{ 'ring-4 ring-[#39D3C4] border-transparent': isSelected('{{ $media->id }}'), 'opacity-50': isComparing && !isSelected('{{ $media->id }}') && selectedForCompare.length >= 2 }">
                                    
                                    <img src="{{ asset('storage/' . $media->file_path) }}" alt="{{ $media->category }}" class="w-full h-full object-cover">
                                    
                                    <!-- Overlay Info -->
                                    <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 via-gray-900/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex flex-col justify-end p-4">
                                        <div class="text-white">
                                            <span class="text-xs font-bold bg-white/20 px-2 py-0.5 rounded backdrop-blur-sm">{{ $media->category }}</span>
                                            <p class="text-sm font-medium mt-1 truncate">{{ $media->taken_at ? $media->taken_at->format('M d, Y') : '' }}</p>
                                        </div>
                                        <div class="absolute top-3 right-3 flex space-x-2" x-show="!isComparing">
                                            <form action="{{ route('media.destroy', $media->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this media?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="p-1.5 bg-red-500 hover:bg-red-600 text-white rounded-lg transition-colors" title="Delete">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    
                                    <!-- Comparison Mode Checkbox Overlay -->
                                    <div x-show="isComparing" class="absolute inset-0 bg-gray-900/30 flex items-center justify-center cursor-pointer" @click="toggleSelection('{{ $media->id }}', '{{ asset('storage/' . $media->file_path) }}', '{{ $media->taken_at ? $media->taken_at->format('M d, Y') : '' }}')">
                                        <div class="w-8 h-8 rounded-full border-2 flex items-center justify-center transition-colors"
                                             :class="isSelected('{{ $media->id }}') ? 'bg-[#39D3C4] border-[#39D3C4] text-white' : 'border-white/70 bg-black/20 text-transparent'">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    
                    <!-- Side-by-Side Comparison Modal -->
                    <div x-show="showCompareModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                            <!-- Background overlay -->
                            <div x-show="showCompareModal" x-transition.opacity class="fixed inset-0 bg-gray-900 bg-opacity-95 transition-opacity" aria-hidden="true"></div>

                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                            
                            <!-- Modal panel -->
                            <div x-show="showCompareModal" 
                                 x-transition:enter="ease-out duration-300" 
                                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                                 x-transition:leave="ease-in duration-200" 
                                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                                 class="inline-block align-bottom bg-gray-900 rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle w-full max-w-7xl border border-gray-800">
                                
                                <div class="px-4 py-4 border-b border-gray-800 flex justify-between items-center bg-black/50">
                                    <h3 class="text-lg leading-6 font-bold text-white flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-[#39D3C4]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                                        Image Comparison
                                    </h3>
                                    <button @click="showCompareModal = false" type="button" class="text-gray-400 hover:text-white focus:outline-none transition-colors">
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                </div>
                                
                                <div class="p-6">
                                    <!-- Before / After Grid -->
                                    <div class="grid grid-cols-2 gap-6 h-[70vh]">
                                        <!-- Image 1 -->
                                        <div class="flex flex-col h-full bg-black rounded-xl overflow-hidden border border-gray-800 relative group">
                                            <div class="absolute top-4 left-4 z-10 bg-black/60 backdrop-blur text-white px-3 py-1 rounded-lg text-sm font-bold border border-white/10" x-text="'Image 1 - ' + selectedForCompare[0]?.date"></div>
                                            <div class="flex-1 w-full h-full relative overflow-hidden flex items-center justify-center p-2">
                                                <img :src="selectedForCompare[0]?.url" class="max-w-full max-h-full object-contain cursor-crosshair transform transition-transform duration-200" style="filter: contrast(1.1) brightness(1.05);">
                                            </div>
                                        </div>
                                        
                                        <!-- Image 2 -->
                                        <div class="flex flex-col h-full bg-black rounded-xl overflow-hidden border border-gray-800 relative group">
                                            <div class="absolute top-4 left-4 z-10 bg-black/60 backdrop-blur text-white px-3 py-1 rounded-lg text-sm font-bold border border-white/10" x-text="'Image 2 - ' + selectedForCompare[1]?.date"></div>
                                            <div class="flex-1 w-full h-full relative overflow-hidden flex items-center justify-center p-2">
                                                <img :src="selectedForCompare[1]?.url" class="max-w-full max-h-full object-contain cursor-crosshair transform transition-transform duration-200" style="filter: contrast(1.1) brightness(1.05);">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Upload Modal -->
                    <div x-show="showUploadModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                            <div x-show="showUploadModal" x-transition.opacity class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                            
                            <div x-show="showUploadModal" 
                                 x-transition:enter="ease-out duration-300" 
                                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                                 x-transition:leave="ease-in duration-200" 
                                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                                 class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                                
                                <form action="{{ route('patients.media.store', $patient) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                        <div class="sm:flex sm:items-start">
                                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                                <h3 class="text-lg leading-6 font-bold text-gray-900 mb-6" id="modal-title">
                                                    Upload Patient Media
                                                </h3>
                                                <div class="mt-2 space-y-4">
                                                    <!-- File Upload -->
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-1">Image File</label>
                                                        <input type="file" name="media_file" required class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-[#39D3C4]/10 file:text-[#2db3a6] hover:file:bg-[#39D3C4]/20 transition-colors">
                                                    </div>
                                                    
                                                    <!-- Category -->
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                                                        <select name="category" required class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-[#39D3C4] focus:ring focus:ring-[#39D3C4] focus:ring-opacity-50 sm:text-sm">
                                                            <option value="X-Ray">X-Ray (Radiograph)</option>
                                                            <option value="Scan">Scan (CT/MRI)</option>
                                                            <option value="Intraoral Photo">Intraoral Photo</option>
                                                            <option value="Document">Document</option>
                                                        </select>
                                                    </div>
                                                    
                                                    <!-- Date Taken -->
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-1">Date Taken</label>
                                                        <input type="date" name="taken_at" value="{{ date('Y-m-d') }}" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-[#39D3C4] focus:ring focus:ring-[#39D3C4] focus:ring-opacity-50 sm:text-sm">
                                                    </div>
                                                    
                                                    <!-- Notes -->
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-1">Notes (Optional)</label>
                                                        <textarea name="notes" rows="2" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-[#39D3C4] focus:ring focus:ring-[#39D3C4] focus:ring-opacity-50 sm:text-sm"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-4 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-100">
                                        <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-[#39D3C4] text-base font-bold text-white hover:bg-[#2db3a6] focus:outline-none sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                                            Upload Media
                                        </button>
                                        <button type="button" @click="showUploadModal = false" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                                            Cancel
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                
                <!-- Finances Tab -->
                <div x-show="tab === 'finances'" style="display: none;" x-transition.opacity.duration.300ms>
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Record Payment Form -->
                        <div class="lg:col-span-1">
                            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-6">
                                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                    <div class="p-2 bg-yellow-50 rounded-xl mr-3">
                                        <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    Record Payment
                                </h3>
                                
                                <form action="{{ route('payments.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="patient_id" value="{{ $patient->id }}">
                                    
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-bold text-gray-700 mb-1">Amount</label>
                                            <div class="relative rounded-md shadow-sm">
                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <span class="text-gray-500 sm:text-sm">$</span>
                                                </div>
                                                <input type="number" step="0.01" name="amount" required class="focus:ring-[#39D3C4] focus:border-[#39D3C4] block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-xl" placeholder="0.00">
                                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                    <span class="text-gray-500 sm:text-sm">USD</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-bold text-gray-700 mb-1">Payment Method</label>
                                            <select name="payment_method" required class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-[#39D3C4] focus:border-[#39D3C4] sm:text-sm rounded-xl">
                                                <option value="cash">Cash</option>
                                                <option value="credit_card">Credit Card</option>
                                                <option value="bank_transfer">Bank Transfer</option>
                                                <option value="insurance">Insurance</option>
                                            </select>
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-bold text-gray-700 mb-1">Notes (Optional)</label>
                                            <textarea name="notes" rows="2" class="shadow-sm focus:ring-[#39D3C4] focus:border-[#39D3C4] block w-full sm:text-sm border-gray-300 rounded-xl" placeholder="e.g. Deposit for implant"></textarea>
                                        </div>
                                        
                                        <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-[#39D3C4] hover:bg-[#2db3a6] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#39D3C4] transition-colors">
                                            Save Payment
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Payment History -->
                        <div class="lg:col-span-2">
                            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                                <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center justify-between">
                                    Payment History
                                    @php
                                        $totalPaid = 0;
                                        foreach($patient->invoices as $inv) {
                                            $totalPaid += $inv->payments->sum('amount');
                                        }
                                    @endphp
                                    <span class="text-sm font-medium text-gray-500 bg-gray-50 px-3 py-1 rounded-lg">Total Paid: <strong class="text-gray-900">{{ format_currency($totalPaid) }}</strong></span>
                                </h3>
                                
                                @if($patient->invoices->count() > 0)
                                    <div class="space-y-4">
                                        @foreach($patient->invoices as $invoice)
                                            @foreach($invoice->payments as $payment)
                                            <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 flex justify-between items-center hover:border-gray-200 transition-colors">
                                                <div class="flex items-center">
                                                    <div class="p-2 {{ $payment->payment_method === 'cash' ? 'bg-green-100 text-green-600' : 'bg-blue-100 text-blue-600' }} rounded-lg mr-4">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                                    </div>
                                                    <div>
                                                        <p class="font-bold text-gray-900">{{ format_currency($payment->amount) }} <span class="text-xs font-normal text-gray-500 uppercase ml-2 bg-gray-200 px-2 py-0.5 rounded-full">{{ str_replace('_', ' ', $payment->payment_method) }}</span></p>
                                                        <p class="text-xs text-gray-500 mt-1">{{ \Carbon\Carbon::parse($payment->payment_date)->format('M d, Y') }} &bull; {{ $payment->notes ?? 'No notes' }}</p>
                                                    </div>
                                                </div>
                                                <div class="text-right">
                                                    <span class="text-xs font-bold text-gray-400">Invoice</span>
                                                    <p class="text-sm font-bold text-gray-700">{{ $invoice->invoice_number }}</p>
                                                </div>
                                            </div>
                                            @endforeach
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-10 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200">
                                        <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <h3 class="text-sm font-bold text-gray-900">No payments yet</h3>
                                        <p class="text-sm text-gray-500 mt-1">Record a payment to see it here.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('xrayComparison', () => ({
                showUploadModal: false,
                isComparing: false,
                showCompareModal: false,
                selectedForCompare: [], // Array of objects {id, url, date}

                toggleCompareMode() {
                    this.isComparing = !this.isComparing;
                    if (!this.isComparing) {
                        this.selectedForCompare = [];
                    }
                },

                isSelected(id) {
                    return this.selectedForCompare.some(item => item.id === id);
                },

                toggleSelection(id, url, date) {
                    if (this.isSelected(id)) {
                        this.selectedForCompare = this.selectedForCompare.filter(item => item.id !== id);
                    } else if (this.selectedForCompare.length < 2) {
                        this.selectedForCompare.push({ id, url, date });
                    }
                },

                openCompareView() {
                    if (this.selectedForCompare.length === 2) {
                        this.showCompareModal = true;
                    }
                }
            }));
            
            Alpine.data('voiceDictation', () => ({
                noteContent: '',
                isRecording: false,
                isProcessing: false,
                mediaRecorder: null,
                audioChunks: [],
                
                async toggleRecording() {
                    if (this.isRecording) {
                        this.isRecording = false;
                        if (this.mediaRecorder) {
                            this.mediaRecorder.stop();
                        }
                    } else {
                        try {
                            const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                            this.mediaRecorder = new MediaRecorder(stream);
                            this.audioChunks = [];
                            
                            this.mediaRecorder.ondataavailable = e => {
                                if (e.data.size > 0) this.audioChunks.push(e.data);
                            };
                            
                            this.mediaRecorder.onstop = async () => {
                                this.isProcessing = true;
                                const audioBlob = new Blob(this.audioChunks, { type: 'audio/webm' });
                                
                                const formData = new FormData();
                                formData.append('audio', audioBlob, 'recording.webm');
                                
                                try {
                                    const res = await fetch('{{ route("patients.notes.voice", $patient) }}', {
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        },
                                        body: formData
                                    });
                                    const data = await res.json();
                                    
                                    if (data.success) {
                                        let currentVal = this.$refs.noteTextarea ? this.$refs.noteTextarea.value : this.noteContent;
                                        let newVal = currentVal + (currentVal ? '\n\n' : '') + data.formatted_text;
                                        this.noteContent = newVal;
                                        if (this.$refs.noteTextarea) {
                                            this.$refs.noteTextarea.value = newVal;
                                            this.$refs.noteTextarea.dispatchEvent(new Event('input', { bubbles: true }));
                                        }
                                    } else {
                                        alert(data.message || 'Error processing audio.');
                                    }
                                } catch (err) {
                                    alert('Error uploading audio.');
                                    console.error(err);
                                }
                                
                                this.isProcessing = false;
                                
                                // Stop all tracks to release microphone
                                stream.getTracks().forEach(track => track.stop());
                            };
                            
                            this.mediaRecorder.start();
                            this.isRecording = true;
                        } catch (err) {
                            alert('Microphone access denied or not available.');
                            console.error(err);
                        }
                    }
                },
                
                insertTemplate(text) {
                    let currentVal = this.$refs.noteTextarea ? this.$refs.noteTextarea.value : this.noteContent;
                    let newVal = currentVal + (currentVal ? '\n\n' : '') + text;
                    this.noteContent = newVal;
                    if (this.$refs.noteTextarea) {
                        this.$refs.noteTextarea.value = newVal;
                        this.$refs.noteTextarea.dispatchEvent(new Event('input', { bubbles: true }));
                    }
                }
            }));
        });
    </script>
    @endpush
</x-app-layout>

