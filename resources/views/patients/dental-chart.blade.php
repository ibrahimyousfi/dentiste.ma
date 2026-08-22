<x-app-layout>
    <x-slot name="header_title">
        <h2 class="font-bold text-xl text-gray-800 leading-tight tracking-tight flex items-center">
            <span class="bg-[#39D3C4]/10 text-[#39D3C4] p-2 rounded-lg mr-3 shadow-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </span>
            <a href="{{ route('patients.show', $patient) }}" class="hover:text-[#39D3C4] transition">{{ $patient->first_name }} {{ $patient->last_name }}</a>
            <span class="mx-2 text-gray-400">/</span>
            {{ __('Interactive Odontogram') }}
        </h2>
    </x-slot>

    <x-slot name="header_actions">
        <div class="text-sm text-gray-500 font-medium mr-4 print:hidden">
            File #PT-{{ str_pad($patient->id, 5, '0', STR_PAD_LEFT) }}
        </div>
        <button type="button" onclick="window.dispatchEvent(new CustomEvent('print-chart'))" class="print:hidden inline-flex items-center px-4 py-2 bg-gray-100 border border-transparent rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 transition shadow-sm whitespace-nowrap mr-2">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Print A5
        </button>
        <button type="button" @click="generatePlan()" class="print:hidden inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition shadow-sm whitespace-nowrap mr-2">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
            Generate Plan
        </button>
        <button type="button" @click="$dispatch('save-odontogram')" class="print:hidden inline-flex items-center px-4 py-2 bg-[#39D3C4] border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#2db3a6] focus:outline-none focus:ring-2 focus:ring-[#39D3C4] focus:ring-offset-2 transition shadow-sm whitespace-nowrap">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
            Save Chart
        </button>
    </x-slot>

    <style>
        /* Only keep standard print table styles for the screen-rendered DOM, 
           the actual print styles will be injected into the popup */
        @media print {
            .print\:hidden {
                display: none !important;
            }
            #print-area {
                display: flex !important;
                visibility: visible !important;
                width: 100% !important;
            }
        }
    </style>

    <!-- Three.js libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/controls/OrbitControls.js"></script>

    <div class="animate-fade-in" x-data="odontogram()" @print-chart.window="printChart()" @save-odontogram.window="saveChart()">
        
        @include('patients.partials.odontogram-screen')
        @include('patients.partials.odontogram-print')
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('odontogram', () => ({
                viewMode: '2D', // '2D' or '3D'
                activeTool: 'eraser',
                treatmentCatalogs: @json($treatmentCatalogs),
                
                chartData: {},
                isSaving: false,
                isChild: @json($isChild),
                canEditChart: @json(auth()->user()->hasRole('Clinic Owner')),
                
                // 3D Engine state
                scene: null, camera: null, renderer: null, controls: null,
                teethMeshMap: {}, raycaster: new THREE.Raycaster(), mouse: new THREE.Vector2(),
                animationId: null,

                // Existing findings from DB
                findings: @json($findings),

                init() {
                    const allTeeth = [
                        18,17,16,15,14,13,12,11, 21,22,23,24,25,26,27,28,
                        48,47,46,45,44,43,42,41, 31,32,33,34,35,36,37,38,
                        55,54,53,52,51, 61,62,63,64,65,
                        85,84,83,82,81, 71,72,73,74,75
                    ];
                    
                    // Initialize empty
                    allTeeth.forEach(t => {
                        this.chartData[t] = {
                            status: 'healthy',
                            surfaces: { T: 'healthy', R: 'healthy', B: 'healthy', L: 'healthy', C: 'healthy' },
                            treatments: [], // array of objects: { catalog_id, name, price }
                            received: 0
                        };
                    });
                    
                    // Populate from DB findings
                    if (this.findings && this.findings.length > 0) {
                        this.findings.forEach(f => {
                            if (this.chartData[f.tooth_number]) {
                                this.chartData[f.tooth_number].status = f.status;
                                if (f.surfaces) {
                                    this.chartData[f.tooth_number].surfaces = f.surfaces;
                                }
                                
                                // Load treatments if they exist
                                if (f.treatments && Array.isArray(f.treatments) && f.treatments.length > 0) {
                                    this.chartData[f.tooth_number].treatments = f.treatments;
                                } 
                                // Legacy price support: if it has a price but no array of treatments, add a generic one
                                else {
                                    let price = f.price ? parseFloat(f.price) : 0;
                                    if (price > 0) {
                                        this.chartData[f.tooth_number].treatments.push({
                                            id: null,
                                            name: 'Legacy Treatment',
                                            price: price
                                        });
                                        this.chartData[f.tooth_number].received = price; // Assume generic received matching price for now
                                    }
                                }
                                
                                if (f.price !== undefined) {
                                    this.chartData[f.tooth_number].price = f.price;
                                }
                                if (f.received !== undefined) {
                                    this.chartData[f.tooth_number].received = parseFloat(f.received);
                                } else {
                                    this.chartData[f.tooth_number].received = 0; 
                                }
                            }
                        });
                    }

                    // Listen for viewMode changes to initialize 3D
                    this.$watch('viewMode', (value) => {
                        if (value === '3D') {
                            this.$nextTick(() => {
                                if (!this.scene) {
                                    this.init3DScene();
                                    this.buildArch3D();
                                    this.add3DEvents();
                                    this.animate();
                                } else {
                                    this.update3DFromData();
                                }
                            });
                        }
                    });

                    // Listen for save and print events
                    window.addEventListener('save-odontogram', () => this.saveChart());
                    window.addEventListener('print-chart', () => this.printChart());
                },

                // --- 3D ENGINE METHODS ---
                init3DScene() {
                    const container = document.getElementById('three-canvas-container');
                    if (!container) return;

                    this.scene = new THREE.Scene();
                    this.scene.background = new THREE.Color(0xf8fafc); // Light clean bg

                    this.camera = new THREE.PerspectiveCamera(45, container.clientWidth / container.clientHeight, 0.1, 1000);
                    this.camera.position.set(0, 25, 35); // Pulled back slightly for better overview

                    this.renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
                    this.renderer.setSize(container.clientWidth, container.clientHeight);
                    this.renderer.setPixelRatio(window.devicePixelRatio);
                    this.renderer.shadowMap.enabled = true;
                    this.renderer.shadowMap.type = THREE.PCFSoftShadowMap;
                    container.appendChild(this.renderer.domElement);

                    this.controls = new THREE.OrbitControls(this.camera, this.renderer.domElement);
                    this.controls.enableDamping = true;
                    this.controls.dampingFactor = 0.05;
                    this.controls.maxPolarAngle = Math.PI / 1.5;

                    const ambientLight = new THREE.AmbientLight(0xffffff, 0.6);
                    this.scene.add(ambientLight);

                    const dirLight = new THREE.DirectionalLight(0xffffff, 0.7);
                    dirLight.position.set(15, 25, 15);
                    dirLight.castShadow = true;
                    dirLight.shadow.mapSize.width = 1024;
                    dirLight.shadow.mapSize.height = 1024;
                    this.scene.add(dirLight);

                    const dirLightBack = new THREE.DirectionalLight(0x39D3C4, 0.3);
                    dirLightBack.position.set(-15, -10, -15);
                    this.scene.add(dirLightBack);
                },

                createProceduralTooth(type) {
                    // Procedural generation of tooth shapes using ExtrudeGeometry
                    let shape = new THREE.Shape();
                    let extrudeSettings = { depth: 1.5, bevelEnabled: true, bevelSegments: 3, steps: 2, bevelSize: 0.1, bevelThickness: 0.1 };

                    if (type === 'incisor') {
                        shape.moveTo(-0.4, -0.2);
                        shape.lineTo(0.4, -0.2);
                        shape.lineTo(0.5, 0.8);
                        shape.quadraticCurveTo(0, 1.1, -0.5, 0.8);
                        extrudeSettings.depth = 0.4;
                    } else if (type === 'canine') {
                        shape.moveTo(-0.4, -0.2);
                        shape.lineTo(0.4, -0.2);
                        shape.lineTo(0.5, 0.6);
                        shape.lineTo(0, 1.2); // Pointy
                        shape.lineTo(-0.5, 0.6);
                        extrudeSettings.depth = 0.5;
                    } else if (type === 'premolar') {
                        shape.moveTo(-0.5, -0.3);
                        shape.lineTo(0.5, -0.3);
                        shape.lineTo(0.6, 0.8);
                        shape.lineTo(0, 1.0); // bicuspid
                        shape.lineTo(-0.6, 0.8);
                        extrudeSettings.depth = 0.8;
                    } else { // molar
                        shape.moveTo(-0.7, -0.5);
                        shape.lineTo(0.7, -0.5);
                        shape.lineTo(0.8, 0.6);
                        shape.lineTo(0.4, 0.9);
                        shape.lineTo(0, 0.7);
                        shape.lineTo(-0.4, 0.9);
                        shape.lineTo(-0.8, 0.6);
                        extrudeSettings.depth = 1.2;
                    }

                    const geo = new THREE.ExtrudeGeometry(shape, extrudeSettings);
                    geo.center(); // Center the geometry
                    return geo;
                },

                buildArch3D() {
                    const gumMaterial = new THREE.MeshStandardMaterial({ color: 0xe07a5f, roughness: 0.4 });
                    
                    const upperGumGeo = new THREE.TorusGeometry(9, 1.5, 16, 100, Math.PI * 1.1);
                    const upperGum = new THREE.Mesh(upperGumGeo, gumMaterial);
                    upperGum.rotation.x = Math.PI / 2;
                    upperGum.position.y = 3;
                    upperGum.receiveShadow = true;
                    this.scene.add(upperGum);

                    const lowerGum = upperGum.clone();
                    lowerGum.position.y = -3;
                    lowerGum.rotation.x = -Math.PI / 2;
                    this.scene.add(lowerGum);

                    const toothBaseMat = new THREE.MeshStandardMaterial({
                        color: 0xffffff,
                        roughness: 0.15,
                        metalness: 0.1,
                        clearcoat: 0.5
                    });

                    const adultTeeth = [
                        18, 17, 16, 15, 14, 13, 12, 11, 21, 22, 23, 24, 25, 26, 27, 28,
                        48, 47, 46, 45, 44, 43, 42, 41, 31, 32, 33, 34, 35, 36, 37, 38
                    ];

                    adultTeeth.forEach((toothNum) => {
                        const isUpper = (toothNum >= 11 && toothNum <= 28);
                        let index = 0;
                        if (toothNum >= 11 && toothNum <= 18) index = toothNum - 11;
                        else if (toothNum >= 21 && toothNum <= 28) index = 21 - toothNum;
                        else if (toothNum >= 41 && toothNum <= 48) index = toothNum - 41;
                        else if (toothNum >= 31 && toothNum <= 38) index = 31 - toothNum;

                        const angle = (index / 8) * (Math.PI / 2.2);
                        const radius = 9;
                        const x = Math.sin(angle) * radius;
                        const z = Math.cos(angle) * radius - 4.5;
                        const y = isUpper ? 3.5 : -3.5;

                        let type = 'molar';
                        if(index === 0 || index === 1) type = 'incisor';
                        else if(index === 2) type = 'canine';
                        else if(index === 3 || index === 4) type = 'premolar';

                        const toothGeo = this.createProceduralTooth(type);
                        const toothMat = toothBaseMat.clone();
                        const toothMesh = new THREE.Mesh(toothGeo, toothMat);
                        
                        toothMesh.position.set(x, y, z);
                        
                        toothMesh.rotation.y = -angle;
                        if(isUpper) {
                            toothMesh.rotation.x = Math.PI;
                        }

                        toothMesh.castShadow = true;
                        toothMesh.receiveShadow = true;
                        toothMesh.userData = { toothNumber: toothNum };

                        this.scene.add(toothMesh);
                        this.teethMeshMap[toothNum] = toothMesh;
                    });
                    
                    this.update3DFromData();
                },

                update3DFromData() {
                    Object.keys(this.teethMeshMap).forEach(num => {
                        const mesh = this.teethMeshMap[num];
                        const data = this.chartData[num];
                        
                        if(data.status === 'extracted') {
                            mesh.visible = false;
                        } else {
                            mesh.visible = true;
                            // Reset color
                            mesh.material.color.setHex(0xffffff);
                            mesh.material.emissive.setHex(0x000000);
                            
                            if(data.status === 'crown') {
                                mesh.material.color.setHex(0xfef08a);
                                mesh.material.metalness = 0.5;
                            } else {
                                mesh.material.metalness = 0.1;
                            }
                            
                            let hasDecay = Object.values(data.surfaces).includes('decayed') || data.status === 'decayed';
                            let hasFill = Object.values(data.surfaces).includes('filled') || data.status === 'filled';
                            
                            if(hasDecay) mesh.material.color.setHex(0xfca5a5);
                            else if(hasFill) mesh.material.color.setHex(0x93c5fd);
                        }
                    });
                },

                add3DEvents() {
                    const container = document.getElementById('three-canvas-container');
                    container.addEventListener('click', (event) => {
                        if (!this.canEditChart) return;
                        const rect = container.getBoundingClientRect();
                        this.mouse.x = ((event.clientX - rect.left) / container.clientWidth) * 2 - 1;
                        this.mouse.y = -((event.clientY - rect.top) / container.clientHeight) * 2 + 1;

                        this.raycaster.setFromCamera(this.mouse, this.camera);
                        const intersects = this.raycaster.intersectObjects(Object.values(this.teethMeshMap));

                        if (intersects.length > 0) {
                            const clickedToothNum = intersects[0].object.userData.toothNumber;
                            // Trigger the regular applyTool flow
                            this.applyTool(clickedToothNum, 'C'); 
                            this.update3DFromData();
                            
                            // Visual click feedback
                            intersects[0].object.material.emissive.setHex(0x39D3C4);
                            setTimeout(() => this.update3DFromData(), 300);
                        }
                    });

                    window.addEventListener('resize', () => {
                        if(this.camera && this.renderer && container && container.clientWidth > 0) {
                            this.camera.aspect = container.clientWidth / container.clientHeight;
                            this.camera.updateProjectionMatrix();
                            this.renderer.setSize(container.clientWidth, container.clientHeight);
                        }
                    });
                },

                animate() {
                    this.animationId = requestAnimationFrame(() => this.animate());
                    if(this.controls) this.controls.update();
                    if(this.renderer && this.scene && this.camera) this.renderer.render(this.scene, this.camera);
                },

                applyTool(tooth, surface = null) {
                    if(!this.canEditChart) return;
                    if(!this.activeTool) return;
                    
                    if(this.activeTool.startsWith('treatment_')) {
                        // It's a catalog treatment
                        let catalogId = this.activeTool.split('_')[1];
                        let item = this.treatmentCatalogs.find(t => t.id == catalogId);
                        if(item) {
                            this.chartData[tooth].treatments.push({
                                id: item.id,
                                name: item.name,
                                price: parseFloat(item.default_price)
                            });
                        }
                    } else {
                        // Basic tools
                        if(this.activeTool === 'eraser') {
                            if(surface) {
                                this.chartData[tooth].surfaces[surface] = 'healthy';
                            } else {
                                this.chartData[tooth].status = 'healthy';
                                this.chartData[tooth].surfaces = { T: 'healthy', R: 'healthy', B: 'healthy', L: 'healthy', C: 'healthy' };
                            }
                        } else if(this.activeTool === 'extracted') {
                            this.chartData[tooth].status = 'extracted';
                        } else if(this.activeTool === 'crown') {
                            this.chartData[tooth].status = 'crown';
                        } else if(['decayed', 'filled'].includes(this.activeTool)) {
                            if(surface) {
                                this.chartData[tooth].surfaces[surface] = this.activeTool;
                                if(this.chartData[tooth].status === 'extracted') this.chartData[tooth].status = 'healthy';
                            } else {
                                this.chartData[tooth].status = this.activeTool; // overall status
                            }
                        }
                    }
                },
                
                isToothAffected(tooth) {
                    if (!this.chartData[tooth]) return false;
                    let data = this.chartData[tooth];
                    if (data.status !== 'healthy') return true;
                    if (data.treatments.length > 0) return true;
                    for (let surf in data.surfaces) {
                        if (data.surfaces[surf] !== 'healthy') return true;
                    }
                    return false;
                },

                hasFindings() {
                    for(let tooth in this.chartData) {
                        if(this.isToothAffected(tooth)) return true;
                    }
                    return false;
                },

                getTreatmentDescription(tooth) {
                    let data = this.chartData[tooth];
                    if(!data) return '';
                    
                    let parts = [];
                    // Add diagnostics
                    if(data.status === 'extracted') parts.push('Extraction (Missing)');
                    if(data.status === 'decayed') parts.push('Decayed');
                    
                    for(let surf in data.surfaces) {
                        if(data.surfaces[surf] === 'decayed') parts.push(`Caries (${surf})`);
                        if(data.surfaces[surf] === 'filled') parts.push(`Filling (${surf})`);
                    }
                    
                    // Add explicit planned treatments
                    data.treatments.forEach(t => {
                        parts.push(t.name);
                    });

                    return parts.join(', ');
                },

                calculateTotal() {
                    let total = 0;
                    for (const tooth in this.chartData) {
                        if (this.isToothAffected(tooth)) {
                            this.chartData[tooth].treatments.forEach(t => {
                                total += parseFloat(t.price || 0);
                            });
                        }
                    }
                    return total;
                },
                
                calculateReceived() {
                    let total = 0;
                    for (const tooth in this.chartData) {
                        if (this.isToothAffected(tooth)) {
                            total += parseFloat(this.chartData[tooth].received || 0);
                        }
                    }
                    return total;
                },
                
                printChart() {
                    const printElement = document.getElementById('print-area');
                    
                    // Capture all CSS from the current page
                    let styles = '';
                    document.querySelectorAll('style, link[rel="stylesheet"]').forEach(node => {
                        styles += node.outerHTML;
                    });

                    // Remove old iframe if it exists
                    let oldIframe = document.getElementById('hidden-print-iframe');
                    if (oldIframe) {
                        oldIframe.remove();
                    }

                    // Create a hidden iframe
                    const iframe = document.createElement('iframe');
                    iframe.id = 'hidden-print-iframe';
                    iframe.style.position = 'absolute';
                    iframe.style.width = '100vw'; // Need real dimensions to render SVG
                    iframe.style.height = '100vh';
                    iframe.style.left = '-9999px';
                    iframe.style.top = '-9999px';
                    iframe.style.border = 'none';
                    document.body.appendChild(iframe);

                    // Inject the HTML and specific print styles into the iframe
                    const doc = iframe.contentWindow.document;
                    doc.head.innerHTML = '<title>Dental Chart - {{ $patient->first_name }} {{ $patient->last_name }}</title>' + styles + '<style>@page{size: landscape; margin: 0 !important;} html, body{margin: 0 !important; padding: 0 !important; width: 100%; height: 100%; background: white !important; -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important;} .a5-container{display: flex; flex-direction: column; width: 100%; height: 100%; padding: 10mm 15mm; box-sizing: border-box; margin: 0; background: white;} .print-header-area{display: flex; justify-content: space-between; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 15px; flex: 0 0 auto;} .print-body-area{display: flex; flex-direction: row; flex: 1 1 auto;} .print-chart-area{width: 45%; display: flex; flex-direction: column; align-items: center; justify-content: flex-start; padding-right: 15px;} .print-table-area{width: 55%; padding-left: 15px; display: flex; flex-direction: column; border-left: 2px solid #000;} .print-table{width: 100%; border-collapse: collapse; font-size: 12px; color: black;} .print-table th, .print-table td{border: 1px solid #000; padding: 6px; text-align: left; color: black;} .print-table th{background-color: #f3f4f6 !important; font-weight: bold; color: black;} .print-chart-scale{width: 550px; transform: scale(0.65); transform-origin: top center; display: flex; flex-direction: column; align-items: center;} ::-webkit-scrollbar{display: none;} .text-gray-500, .text-gray-600, .text-gray-700, .text-gray-900{color: black !important;}</style>';
                    doc.body.style.background = 'white';
                    doc.body.innerHTML = '<div class="a5-container">' + printElement.innerHTML + '</div>';

                    // Wait for external CSS to load before printing the iframe
                    setTimeout(() => {
                        iframe.contentWindow.focus();
                        iframe.contentWindow.print();
                    }, 1200); // Increased wait time to ensure styles and SVGs render
                },

                getGroupedTreatments() {
                    const groups = {};

                    for (const tooth in this.chartData) {
                        if (this.isToothAffected(tooth)) {
                            // Sum up price from treatments array
                            let toothTotalPrice = 0;
                            this.chartData[tooth].treatments.forEach(t => {
                                toothTotalPrice += parseFloat(t.price || 0);
                            });

                            const desc = this.getTreatmentDescription(tooth) || 'Consultation / Diagnosis';
                            if (!groups[desc]) {
                                groups[desc] = {
                                    description: desc,
                                    teeth: [],
                                    totalPrice: 0,
                                    totalReceived: 0
                                };
                            }
                            groups[desc].teeth.push(tooth);
                            groups[desc].totalPrice += toothTotalPrice;
                            groups[desc].totalReceived += parseFloat(this.chartData[tooth].received || 0);
                        }
                    }

                    return Object.values(groups);
                },

                formatPrice(price) {
                    return (parseFloat(price) || 0).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' DH';
                },

                getArchStyle(tooth) {
                    let isUpper = false;
                    let isAdult = true;
                    let index = 0;
                    
                    let t = parseInt(tooth);
                    
                    if(t >= 11 && t <= 18) { isUpper = true; isAdult = true; index = t - 11; }
                    if(t >= 21 && t <= 28) { isUpper = true; isAdult = true; index = t - 21; }
                    
                    if(t >= 41 && t <= 48) { isUpper = false; isAdult = true; index = t - 41; }
                    if(t >= 31 && t <= 38) { isUpper = false; isAdult = true; index = t - 31; }
                    
                    if(t >= 51 && t <= 55) { isUpper = true; isAdult = false; index = t - 51; }
                    if(t >= 61 && t <= 65) { isUpper = true; isAdult = false; index = t - 61; }
                    
                    if(t >= 81 && t <= 85) { isUpper = false; isAdult = false; index = t - 81; }
                    if(t >= 71 && t <= 75) { isUpper = false; isAdult = false; index = t - 71; }
                    
                    // Create a perfect U-shape curve
                    let multY = isAdult ? 6.0 : 7.0;
                    let multX = isAdult ? 2.5 : 3.0;
                    
                    let y = Math.pow(index, 1.4) * multY;
                    let x = Math.pow(index, 1.2) * multX;
                    
                    // Push molars outward (widen the U shape symmetrically)
                    let isLeftQuad = (t >= 11 && t <= 18) || (t >= 41 && t <= 48) || (t >= 51 && t <= 55) || (t >= 81 && t <= 85);
                    if (isLeftQuad) {
                        x = -x;
                    }
                    
                    // Invert Y for lower arch
                    if(!isUpper) y = -y;
                    
                    return `transform: translate3d(${x}px, ${y}px, 0);`;
                },

                getPrintArchStyle(tooth) {
                    let t = parseInt(tooth);
                    let isUpper = false;
                    let isAdult = true;
                    let index = 0; 
                    let isLeftQuad = false; // Patient's right is Screen's left

                    if(t >= 11 && t <= 18) { isUpper = true; isAdult = true; index = t - 11; isLeftQuad = true; } 
                    if(t >= 21 && t <= 28) { isUpper = true; isAdult = true; index = t - 21; isLeftQuad = false; } 
                    
                    if(t >= 41 && t <= 48) { isUpper = false; isAdult = true; index = t - 41; isLeftQuad = true; }
                    if(t >= 31 && t <= 38) { isUpper = false; isAdult = true; index = t - 31; isLeftQuad = false; }
                    
                    if(t >= 51 && t <= 55) { isUpper = true; isAdult = false; index = t - 51; isLeftQuad = true; }
                    if(t >= 61 && t <= 65) { isUpper = true; isAdult = false; index = t - 61; isLeftQuad = false; }
                    
                    if(t >= 81 && t <= 85) { isUpper = false; isAdult = false; index = t - 81; isLeftQuad = true; }
                    if(t >= 71 && t <= 75) { isUpper = false; isAdult = false; index = t - 71; isLeftQuad = false; }

                    let totalTeeth = isAdult ? 8.2 : 5.2; 
                    let angleProgress = (index + 0.5) / totalTeeth; 
                    let angleRad = angleProgress * (Math.PI / 2); 
                    
                    if (isLeftQuad) {
                        angleRad = -angleRad; 
                    }
                    
                    let rx = isAdult ? 180 : 100;
                    let ry = isAdult ? 220 : 120;
                    
                    let x = Math.sin(angleRad) * rx;
                    let y = Math.cos(angleRad) * ry; 
                    
                    if (isUpper) {
                        y = -y;
                    }
                    
                    // Push the upper and lower arches slightly apart
                    let originY = isUpper ? -30 : 30; 
                    y = y + originY;
                    
                    return `position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%) translate(${x}px, ${y}px);`;
                },
                
                getPrintNumberStyle(tooth) {
                    let t = parseInt(tooth);
                    let isUpper = false;
                    let isAdult = true;
                    let index = 0; 
                    let isLeftQuad = false; 

                    if(t >= 11 && t <= 18) { isUpper = true; isAdult = true; index = t - 11; isLeftQuad = true; } 
                    if(t >= 21 && t <= 28) { isUpper = true; isAdult = true; index = t - 21; isLeftQuad = false; } 
                    if(t >= 41 && t <= 48) { isUpper = false; isAdult = true; index = t - 41; isLeftQuad = true; }
                    if(t >= 31 && t <= 38) { isUpper = false; isAdult = true; index = t - 31; isLeftQuad = false; }
                    if(t >= 51 && t <= 55) { isUpper = true; isAdult = false; index = t - 51; isLeftQuad = true; }
                    if(t >= 61 && t <= 65) { isUpper = true; isAdult = false; index = t - 61; isLeftQuad = false; }
                    if(t >= 81 && t <= 85) { isUpper = false; isAdult = false; index = t - 81; isLeftQuad = true; }
                    if(t >= 71 && t <= 75) { isUpper = false; isAdult = false; index = t - 71; isLeftQuad = false; }

                    let totalTeeth = isAdult ? 8.2 : 5.2; 
                    let angleProgress = (index + 0.5) / totalTeeth; 
                    let angleRad = angleProgress * (Math.PI / 2); 
                    
                    if (isLeftQuad) {
                        angleRad = -angleRad; 
                    }
                    
                    let offset = isAdult ? 40 : 25; // How far out the number is from the tooth center
                    let rx = (isAdult ? 180 : 100) + offset;
                    let ry = (isAdult ? 220 : 120) + offset;
                    
                    let x = Math.sin(angleRad) * rx;
                    let y = Math.cos(angleRad) * ry; 
                    
                    if (isUpper) {
                        y = -y;
                    }
                    
                    let originY = isUpper ? -30 : 30; 
                    y = y + originY;
                    
                    return `position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%) translate(${x}px, ${y}px);`;
                },
                
                isUpperTooth(tooth) {
                    let t = parseInt(tooth);
                    return (t >= 11 && t <= 28) || (t >= 51 && t <= 65);
                },
                
                isAdultTooth(tooth) {
                    let t = parseInt(tooth);
                    return (t >= 11 && t <= 48);
                },

                isToothAffected(tooth) {
                    let data = this.chartData[tooth];
                    if(!data) return false;
                    if(data.status !== 'healthy') return true;
                    return Object.values(data.surfaces).some(s => s !== 'healthy');
                },

                hasFindings() {
                    return Object.keys(this.chartData).some(t => this.isToothAffected(t));
                },

                getTreatmentDescription(tooth) {
                    let data = this.chartData[tooth];
                    if(!data) return '';
                    
                    let parts = [];
                    
                    // Diagnostics
                    if(data.status === 'extracted') parts.push('Extraction (Missing)');
                    if(data.status === 'crown') parts.push('Crown / Bridge');
                    if(data.status === 'decayed') parts.push('Decayed');
                    
                    for(let surf in data.surfaces) {
                        if(data.surfaces[surf] === 'decayed') parts.push(`Caries (${surf})`);
                        if(data.surfaces[surf] === 'filled') parts.push(`Filling (${surf})`);
                    }
                    
                    // Explicit Planned Treatments from Catalog
                    if (data.treatments && data.treatments.length > 0) {
                        data.treatments.forEach(t => {
                            parts.push(t.name);
                        });
                    }

                    return parts.join(', ');
                },

                calculateTotal() {
                    let total = 0;
                    for (const tooth in this.chartData) {
                        if (this.isToothAffected(tooth)) {
                            total += parseFloat(this.chartData[tooth].price || 0);
                        }
                    }
                    return total;
                },
                
                calculateReceived() {
                    let total = 0;
                    for (const tooth in this.chartData) {
                        if (this.isToothAffected(tooth)) {
                            total += parseFloat(this.chartData[tooth].received || 0);
                        }
                    }
                    return total;
                },

                getGroupedTreatments() {
                    const groups = {};

                    for (const tooth in this.chartData) {
                        if (this.isToothAffected(tooth)) {
                            // Sum up price from treatments array
                            let toothTotalPrice = 0;
                            this.chartData[tooth].treatments.forEach(t => {
                                toothTotalPrice += parseFloat(t.price || 0);
                            });

                            const desc = this.getTreatmentDescription(tooth) || 'Consultation / Diagnosis';
                            if (!groups[desc]) {
                                groups[desc] = {
                                    description: desc,
                                    teeth: [],
                                    totalPrice: 0,
                                    totalReceived: 0
                                };
                            }
                            groups[desc].teeth.push(tooth);
                            groups[desc].totalPrice += toothTotalPrice;
                            groups[desc].totalReceived += parseFloat(this.chartData[tooth].received || 0);
                        }
                    }

                    return Object.values(groups);
                },

                formatPrice(price) {
                    return (parseFloat(price) || 0).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' DH';
                },

                // Remove applyTool, we now use openEditor

                getSurfaceColor(tooth, surface) {
                    let data = this.chartData[tooth];
                    if(!data) return '#ffffff'; // White (healthy)
                    
                    if(data.status === 'extracted') return 'none';
                    if(data.status === 'crown') return '#fef08a'; // Yellow
                    
                    let surfStatus = data.surfaces[surface];
                    if(surfStatus === 'decayed') return '#ef4444'; // Red
                    if(surfStatus === 'filled') return '#3b82f6'; // Blue
                    
                    return '#ffffff'; // White
                },

                getToothStroke(tooth) {
                    let data = this.chartData[tooth];
                    if(!data) return '#d1d5db';
                    if(data.status === 'extracted') return 'none'; 
                    if(data.status === 'crown') return '#ca8a04';
                    return '#9ca3af'; // Slightly darker border for better visibility
                },

                // Renders the interactive tooth SVG directly on the chart
                renderToothInteractive(tooth) {
                    if(!tooth) return '';
                    let data = this.chartData[tooth];

                    let stroke = this.getToothStroke(tooth);
                    let cT = this.getSurfaceColor(tooth, 'T');
                    let cR = this.getSurfaceColor(tooth, 'R');
                    let cB = this.getSurfaceColor(tooth, 'B');
                    let cL = this.getSurfaceColor(tooth, 'L');
                    let cC = this.getSurfaceColor(tooth, 'C');

                    let isExtracted = data && data.status === 'extracted';
                    let hasTreatments = data && data.treatments.length > 0;

                    let svg = `<svg viewBox="0 0 100 100" class="w-full h-full relative" @click.stop="applyTool(${tooth}, null)">`;
                    
                    if(isExtracted) {
                        svg += `
                            <!-- Invisible background to catch clicks -->
                            <rect x="0" y="0" width="100" height="100" fill="transparent" class="cursor-pointer" />
                            <line x1="10" y1="10" x2="90" y2="90" stroke="#9ca3af" stroke-width="8" stroke-linecap="round" class="pointer-events-none"/>
                            <line x1="90" y1="10" x2="10" y2="90" stroke="#9ca3af" stroke-width="8" stroke-linecap="round" class="pointer-events-none"/>
                        `;
                    } else {
                        // Interactive 5-surface layout
                        svg += `
                            <circle cx="50" cy="50" r="48" fill="#ffffff" stroke="${stroke}" stroke-width="3" class="pointer-events-none"/>
                            
                            <polygon points="15,15 85,15 65,35 35,35" fill="${cT}" stroke="${stroke}" stroke-width="2" class="cursor-pointer hover:opacity-75 transition-opacity" @click.stop="applyTool(${tooth}, 'T')"/>
                            
                            <polygon points="85,15 85,85 65,65 65,35" fill="${cR}" stroke="${stroke}" stroke-width="2" class="cursor-pointer hover:opacity-75 transition-opacity" @click.stop="applyTool(${tooth}, 'R')"/>
                            
                            <polygon points="15,85 85,85 65,65 35,65" fill="${cB}" stroke="${stroke}" stroke-width="2" class="cursor-pointer hover:opacity-75 transition-opacity" @click.stop="applyTool(${tooth}, 'B')"/>
                            
                            <polygon points="15,15 15,85 35,65 35,35" fill="${cL}" stroke="${stroke}" stroke-width="2" class="cursor-pointer hover:opacity-75 transition-opacity" @click.stop="applyTool(${tooth}, 'L')"/>
                            
                            <rect x="35" y="35" width="30" height="30" fill="${cC}" stroke="${stroke}" stroke-width="2" class="cursor-pointer hover:opacity-75 transition-opacity" @click.stop="applyTool(${tooth}, 'C')"/>
                        `;
                    }

                    // Add a tiny badge/indicator if treatments are planned
                    if(hasTreatments) {
                        svg += `
                            <circle cx="85" cy="15" r="12" fill="#39D3C4" stroke="#ffffff" stroke-width="2" class="pointer-events-none"/>
                        `;
                    }

                    svg += `</svg>`;
                    return svg;
                },

                saveChart() {
                    if (this.isSaving) return;
                    this.isSaving = true;
                    
                    fetch('{{ route("patients.dental-chart.store", $patient) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ chartData: this.chartData })
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.isSaving = false;
                        if(data.success) {
                            alert('Chart saved successfully!');
                        }
                    })
                    .catch(err => {
                        this.isSaving = false;
                        alert('Error saving chart.');
                        console.error(err);
                    });
                },

                generatePlan() {
                    if (this.isSaving) return;
                    
                    if (!confirm('This will generate a formal Treatment Plan based on the currently saved chart. Make sure you have saved the chart first. Proceed?')) return;
                    
                    this.isSaving = true;
                    
                    fetch('{{ route("patients.dental-chart.generate-plan", $patient) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.isSaving = false;
                        if(data.success && data.redirect_url) {
                            window.location.href = data.redirect_url;
                        } else {
                            alert(data.message || 'Error generating plan.');
                        }
                    })
                    .catch(err => {
                        this.isSaving = false;
                        alert('Error generating plan.');
                        console.error(err);
                    });
                }
            }));
        });

        // Make the tools panel draggable
        document.addEventListener('DOMContentLoaded', () => {
            const toolsPanel = document.getElementById('clinical-tools');
            if (toolsPanel) {
                let isDragging = false;
                let startX, startY, initialX, initialY;

                toolsPanel.addEventListener('mousedown', (e) => {
                    // Only drag if clicking on the header
                    if(!e.target.closest('.cursor-move')) return;
                    
                    isDragging = true;
                    startX = e.clientX;
                    startY = e.clientY;
                    
                    const rect = toolsPanel.getBoundingClientRect();
                    initialX = rect.left;
                    initialY = rect.top;
                    
                    toolsPanel.style.right = 'auto'; // Disable right anchoring
                    toolsPanel.style.left = initialX + 'px';
                    toolsPanel.style.top = initialY + 'px';
                });

                document.addEventListener('mousemove', (e) => {
                    if (!isDragging) return;
                    e.preventDefault();
                    
                    const dx = e.clientX - startX;
                    const dy = e.clientY - startY;
                    
                    toolsPanel.style.left = (initialX + dx) + 'px';
                    toolsPanel.style.top = (initialY + dy) + 'px';
                });

                document.addEventListener('mouseup', () => {
                    isDragging = false;
                });
            }
        });
    </script>
</x-app-layout>
