        <div class="print:hidden">
            <div class="w-full space-y-8 relative pb-24">
                
                <div class="space-y-8">
                    <div class="bg-white p-4 sm:p-6 rounded-3xl shadow-sm border border-gray-100">

                        <!-- Magic Tool (inline, above chart) -->
                        <div class="bg-gray-50 border border-gray-100 rounded-2xl p-3 mb-6">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="text-xs font-black text-gray-500 uppercase tracking-wider mr-2">View:</span>
                                <button @click="viewMode = '2D'" :class="viewMode === '2D' ? 'bg-white ring-2 ring-[#39D3C4] font-bold shadow text-[#39D3C4]' : 'hover:bg-white text-gray-600'" class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs transition-all font-medium">
                                    2D Chart
                                </button>
                                <button @click="viewMode = '3D'" :class="viewMode === '3D' ? 'bg-white ring-2 ring-[#39D3C4] font-bold shadow text-[#39D3C4]' : 'hover:bg-white text-gray-600'" class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs transition-all font-medium mr-4">
                                    3D Realistic
                                </button>

                                <span class="text-xs font-black text-gray-500 uppercase tracking-wider border-l border-gray-300 pl-4 ml-2">Tool:</span>
                                <button @click="activeTool = 'eraser'" :class="activeTool === 'eraser' ? 'bg-white ring-2 ring-gray-400 font-bold shadow' : 'hover:bg-white'" class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs text-gray-700 transition-all font-medium">
                                    <span>🧹</span> Eraser
                                </button>
                                <button @click="activeTool = 'decayed'" :class="activeTool === 'decayed' ? 'bg-red-50 ring-2 ring-red-400 font-bold text-red-700 shadow' : 'hover:bg-red-50'" class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs text-gray-700 transition-all font-medium">
                                    <span class="w-3 h-3 rounded bg-[#ef4444] inline-block"></span> Caries
                                </button>
                                <button @click="activeTool = 'filled'" :class="activeTool === 'filled' ? 'bg-blue-50 ring-2 ring-blue-400 font-bold text-blue-700 shadow' : 'hover:bg-blue-50'" class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs text-gray-700 transition-all font-medium">
                                    <span class="w-3 h-3 rounded bg-[#3b82f6] inline-block"></span> Filling
                                </button>
                                <button @click="activeTool = 'crown'" :class="activeTool === 'crown' ? 'bg-yellow-50 ring-2 ring-yellow-400 font-bold text-yellow-700 shadow' : 'hover:bg-yellow-50'" class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs text-gray-700 transition-all font-medium">
                                    <span class="w-3 h-3 rounded bg-[#eab308] inline-block"></span> Crown
                                </button>
                                <button @click="activeTool = 'extracted'" :class="activeTool === 'extracted' ? 'bg-gray-200 ring-2 ring-gray-500 font-bold shadow' : 'hover:bg-gray-100'" class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs text-gray-700 transition-all font-medium">
                                    <svg class="w-3 h-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg> Extracted
                                </button>
                                <select x-model="activeTool" class="border-gray-200 rounded-xl focus:border-[#39D3C4] focus:ring-[#39D3C4] text-xs py-1.5 bg-white font-medium">
                                    <option value="">-- Catalog --</option>
                                    <template x-for="item in treatmentCatalogs" :key="item.id">
                                        <option :value="'treatment_' + item.id" x-text="`${item.name} (${item.default_price} DH)`"></option>
                                    </template>
                                </select>
                                <button @click="$dispatch('save-odontogram')" :disabled="isSaving" class="flex items-center gap-1.5 px-4 py-1.5 bg-[#39D3C4] text-white rounded-xl text-xs font-bold hover:bg-[#2db3a6] transition-colors disabled:opacity-50">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                                    Save
                                </button>
                                <button @click="generatePlan()" class="flex items-center gap-1.5 px-4 py-1.5 bg-indigo-600 text-white rounded-xl text-xs font-bold hover:bg-indigo-700 transition-colors">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                    Generate Plan
                                </button>
                                <button onclick="window.open('{{ route('patients.dental-chart.print', $patient) }}', '_blank')" class="flex items-center gap-1.5 px-4 py-1.5 bg-gray-100 text-gray-700 rounded-xl text-xs font-bold hover:bg-gray-200 transition-colors">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                    Print
                                </button>
                            </div>
                        </div>

                        <!-- 3D Realistic View – always in DOM so Three.js reads real dimensions -->
                        <div :style="viewMode === '3D' ? 'display:block' : 'display:none'" class="w-full relative rounded-2xl overflow-hidden border border-gray-100" style="height: 600px;">
                            <div id="three-canvas-container" class="w-full h-full cursor-grab active:cursor-grabbing"></div>

                            <!-- Loading overlay -->
                            <div x-show="viewMode === '3D' && !scene" class="absolute inset-0 flex items-center justify-center bg-white/80 backdrop-blur-sm">
                                <div class="text-center">
                                    <svg class="animate-spin h-8 w-8 text-[#39D3C4] mx-auto mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path></svg>
                                    <p class="text-sm text-gray-500 font-medium">Loading 3D view…</p>
                                </div>
                            </div>

                            <!-- 3D Controls Hint -->
                            <div class="absolute bottom-4 left-4 bg-white/80 backdrop-blur-sm px-4 py-2 rounded-xl text-xs text-gray-600 font-medium shadow-sm border border-gray-100 pointer-events-none">
                                <span class="font-bold text-gray-800">Tip:</span> Drag to rotate · Scroll to zoom · Right-drag to pan
                            </div>
                        </div>

                        <!-- 2D SVG View -->
                        <div class="w-full" x-show="viewMode === '2D' && !isChild">
                            <!-- Adult Maxillary (Upper) -->
                            <div class="mb-2 text-center text-xs font-bold text-gray-400 uppercase tracking-widest">Upper Arch (Maxillary)</div>
                            <div class="flex justify-center gap-1 mb-8 pb-32">
                                <!-- Q1: 18 to 11 -->
                                <div class="flex gap-1 border-r-2 border-gray-100 pr-2">
                                    <template x-for="tooth in [18,17,16,15,14,13,12,11]" :key="tooth">
                                        <div class="flex flex-col items-center group cursor-pointer transition-transform duration-300" :style="getArchStyle(tooth)">
                                            <span class="text-xs font-bold text-gray-400 mb-1" x-text="tooth"></span>
                                            <div class="w-8 h-8 sm:w-11 sm:h-11 relative drop-shadow-sm hover:scale-110 transition-transform">
                                                <div x-html="renderToothInteractive(tooth)"></div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                                <!-- Q2: 21 to 28 -->
                                <div class="flex gap-1 pl-2">
                                    <template x-for="tooth in [21,22,23,24,25,26,27,28]" :key="tooth">
                                        <div class="flex flex-col items-center group cursor-pointer transition-transform duration-300" :style="getArchStyle(tooth)">
                                            <span class="text-xs font-bold text-gray-400 mb-1" x-text="tooth"></span>
                                            <div class="w-8 h-8 sm:w-11 sm:h-11 relative drop-shadow-sm hover:scale-110 transition-transform">
                                                <div x-html="renderToothInteractive(tooth)"></div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            <!-- Adult Mandibular (Lower) -->
                            <div class="mb-2 text-center text-xs font-bold text-gray-400 uppercase tracking-widest mt-16">Lower Arch (Mandibular)</div>
                            <div class="flex justify-center gap-1 mb-8 pt-32">
                                <!-- Q4: 48 to 41 -->
                                <div class="flex gap-1 border-r-2 border-gray-100 pr-2">
                                    <template x-for="tooth in [48,47,46,45,44,43,42,41]" :key="tooth">
                                        <div class="flex flex-col items-center group cursor-pointer transition-transform duration-300" :style="getArchStyle(tooth)">
                                            <div class="w-8 h-8 sm:w-11 sm:h-11 relative drop-shadow-sm hover:scale-110 transition-transform">
                                                <div x-html="renderToothInteractive(tooth)"></div>
                                            </div>
                                            <span class="text-xs font-bold text-gray-400 mt-1" x-text="tooth"></span>
                                        </div>
                                    </template>
                                </div>
                                <!-- Q3: 31 to 38 -->
                                <div class="flex gap-1 pl-2">
                                    <template x-for="tooth in [31,32,33,34,35,36,37,38]" :key="tooth">
                                        <div class="flex flex-col items-center group cursor-pointer transition-transform duration-300" :style="getArchStyle(tooth)">
                                            <div class="w-8 h-8 sm:w-11 sm:h-11 relative drop-shadow-sm hover:scale-110 transition-transform">
                                                <div x-html="renderToothInteractive(tooth)"></div>
                                            </div>
                                            <span class="text-xs font-bold text-gray-400 mt-1" x-text="tooth"></span>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div> <!-- End Adult Chart -->

                        <div class="w-full" x-show="viewMode === '2D' && isChild">

                            <!-- Child Maxillary -->
                            <div class="flex justify-center gap-1 mb-8 pb-20">
                                <!-- Q1: 55 to 51 -->
                                <div class="flex gap-1 border-r-2 border-gray-100 pr-2">
                                    <template x-for="tooth in [55,54,53,52,51]" :key="tooth">
                                        <div class="flex flex-col items-center group cursor-pointer transition-transform duration-300" :style="getArchStyle(tooth)">
                                            <span class="text-xs font-bold text-gray-400 mb-1" x-text="tooth"></span>
                                            <div class="w-8 h-8 sm:w-10 sm:h-10 relative drop-shadow-sm hover:scale-110 transition-transform">
                                                <div x-html="renderToothInteractive(tooth)"></div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                                <!-- Q2: 61 to 65 -->
                                <div class="flex gap-1 pl-2">
                                    <template x-for="tooth in [61,62,63,64,65]" :key="tooth">
                                        <div class="flex flex-col items-center group cursor-pointer transition-transform duration-300" :style="getArchStyle(tooth)">
                                            <span class="text-xs font-bold text-gray-400 mb-1" x-text="tooth"></span>
                                            <div class="w-8 h-8 sm:w-10 sm:h-10 relative drop-shadow-sm hover:scale-110 transition-transform">
                                                <div x-html="renderToothInteractive(tooth)"></div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            <!-- Child Mandibular -->
                            <div class="flex justify-center gap-1 pt-20">
                                <!-- Q4: 85 to 81 -->
                                <div class="flex gap-1 border-r-2 border-gray-100 pr-2">
                                    <template x-for="tooth in [85,84,83,82,81]" :key="tooth">
                                        <div class="flex flex-col items-center group cursor-pointer transition-transform duration-300" :style="getArchStyle(tooth)">
                                            <div class="w-8 h-8 sm:w-10 sm:h-10 relative drop-shadow-sm hover:scale-110 transition-transform">
                                                <div x-html="renderToothInteractive(tooth)"></div>
                                            </div>
                                            <span class="text-xs font-bold text-gray-400 mt-1" x-text="tooth"></span>
                                        </div>
                                    </template>
                                </div>
                                <!-- Q3: 71 to 75 -->
                                <div class="flex gap-1 pl-2">
                                    <template x-for="tooth in [71,72,73,74,75]" :key="tooth">
                                        <div class="flex flex-col items-center group cursor-pointer transition-transform duration-300" :style="getArchStyle(tooth)">
                                            <div class="w-8 h-8 sm:w-10 sm:h-10 relative drop-shadow-sm hover:scale-110 transition-transform">
                                                <div x-html="renderToothInteractive(tooth)"></div>
                                            </div>
                                            <span class="text-xs font-bold text-gray-400 mt-1" x-text="tooth"></span>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div> <!-- End Child Chart -->
                    </div> <!-- End 2D/3D Container (Implicit end) -->
                </div>

                <!-- Treatment Estimate Table -->
                <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-sm border border-gray-100">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <svg class="w-6 h-6 text-[#39D3C4] mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Financial Records & Operations
                    </h3>
                    
                    <div class="overflow-x-auto border border-gray-100 rounded-xl">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-3 py-2 text-left font-bold text-gray-500 uppercase tracking-wider">Dates</th>
                                    <th scope="col" class="px-3 py-2 text-left font-bold text-gray-500 uppercase tracking-wider">Natures des Opérations</th>
                                    <th scope="col" class="px-3 py-2 text-right font-bold text-gray-500 uppercase tracking-wider">Prix Convenu</th>
                                    <th scope="col" class="px-3 py-2 text-right font-bold text-gray-500 uppercase tracking-wider">Reçu</th>
                                    <th scope="col" class="px-3 py-2 text-right font-bold text-gray-500 uppercase tracking-wider">A Recevoir</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                <template x-for="tooth in Object.keys(chartData)" :key="tooth">
                                    <tr x-show="isToothAffected(tooth)" class="hover:bg-gray-50 transition-colors">
                                        <td class="px-3 py-2 whitespace-nowrap text-gray-600">
                                            {{ date('d/m/y') }}
                                        </td>
                                        <td class="px-3 py-2 whitespace-nowrap text-gray-900 font-medium">
                                            <span x-text="tooth + ' : ' + getTreatmentDescription(tooth)"></span>
                                        </td>
                                        <td class="px-3 py-2 whitespace-nowrap text-right">
                                            <div class="flex items-center justify-end">
                                                <input type="number" min="0" step="50" x-model.number="chartData[tooth].price" class="w-20 text-right rounded border-gray-300 focus:border-[#39D3C4] focus:ring-[#39D3C4] sm:text-xs py-1 px-2">
                                            </div>
                                        </td>
                                        <td class="px-3 py-2 whitespace-nowrap text-right">
                                            <div class="flex items-center justify-end">
                                                <input type="number" min="0" step="50" x-model.number="chartData[tooth].received" class="w-20 text-right rounded border-gray-300 focus:border-[#39D3C4] focus:ring-[#39D3C4] sm:text-xs py-1 px-2">
                                            </div>
                                        </td>
                                        <td class="px-3 py-2 whitespace-nowrap text-right font-bold text-[#39D3C4]" x-text="formatPrice( (chartData[tooth].price || 0) - (chartData[tooth].received || 0) )">
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                            <tfoot class="bg-gray-50 font-bold border-t-2 border-gray-200">
                                <tr>
                                    <td colspan="2" class="px-3 py-3 text-center text-gray-900 uppercase tracking-wider">A Reporter</td>
                                    <td class="px-3 py-3 text-right text-gray-900" x-text="formatPrice(calculateTotal())"></td>
                                    <td class="px-3 py-3 text-right text-gray-900" x-text="formatPrice(calculateReceived())"></td>
                                    <td class="px-3 py-3 text-right text-xl text-[#39D3C4]" x-text="formatPrice(calculateTotal() - calculateReceived())"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

            </div>
        </div>

            <!-- End Screen View -->
