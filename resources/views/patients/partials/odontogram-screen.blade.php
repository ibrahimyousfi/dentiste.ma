        <!-- ========================================== -->
        <!--                  SCREEN VIEW                 -->
        <!-- ========================================== -->
        <div class="print:hidden">
            <div class="max-w-5xl mx-auto space-y-8 relative pb-24">
                
                <!-- Main Content Area -->
                <div class="space-y-8">
                    <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-sm border border-gray-100">
                    
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
                            <h3 class="text-xl font-bold text-gray-900">Dental Odontogram</h3>
                            <div class="flex flex-wrap gap-4 text-xs font-semibold text-gray-500">
                                <span class="flex items-center"><span class="w-3 h-3 rounded bg-[#ef4444] mr-1.5"></span> Caries</span>
                                <span class="flex items-center"><span class="w-3 h-3 rounded bg-[#3b82f6] mr-1.5"></span> Filling</span>
                                <span class="flex items-center"><span class="w-3 h-3 rounded bg-[#eab308] mr-1.5"></span> Crown</span>
                                <span class="flex items-center"><span class="w-3 h-3 rounded border-2 border-[#6b7280] mr-1.5"></span> Extracted</span>
                            </div>
                        </div>

                        <div class="w-full" x-show="!isChild">
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

                        <div class="w-full" x-show="isChild">
                            <h3 class="text-xl font-bold text-gray-900 mb-8">Pediatric Chart (Child)</h3>

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
                        </div>
                    </div>
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

            <!-- Floating Clinical Tools (Draggable) -->
            <div id="clinical-tools" class="fixed top-24 right-8 bg-white/95 backdrop-blur-md p-5 rounded-3xl shadow-2xl border border-gray-100 z-40 w-72 cursor-move hidden lg:block" style="touch-action: none;">
                <div class="flex items-center justify-between mb-4 border-b border-gray-100 pb-3 cursor-move">
                    <h4 class="text-sm font-black text-gray-900 flex items-center tracking-wide uppercase">
                        <svg class="w-5 h-5 mr-2 text-[#39D3C4]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                        Magic Tool
                    </h4>
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path></svg>
                </div>
                
                <div class="space-y-2 mb-4">
                    <button @click="activeTool = 'eraser'" :class="activeTool === 'eraser' ? 'bg-gray-100 ring-2 ring-gray-400 font-bold' : 'hover:bg-gray-50'" class="w-full flex items-center p-2.5 rounded-xl text-sm text-gray-700 transition-all font-medium">
                        <span class="w-6 h-6 rounded bg-white border border-gray-200 flex items-center justify-center mr-3 text-xs shadow-sm">🧹</span> Eraser / Healthy
                    </button>
                    <button @click="activeTool = 'decayed'" :class="activeTool === 'decayed' ? 'bg-red-50 ring-2 ring-red-400 font-bold text-red-700' : 'hover:bg-red-50'" class="w-full flex items-center p-2.5 rounded-xl text-sm text-gray-700 transition-all font-medium">
                        <span class="w-6 h-6 rounded bg-[#ef4444] mr-3 shadow-sm"></span> Caries (Decay)
                    </button>
                    <button @click="activeTool = 'filled'" :class="activeTool === 'filled' ? 'bg-blue-50 ring-2 ring-blue-400 font-bold text-blue-700' : 'hover:bg-blue-50'" class="w-full flex items-center p-2.5 rounded-xl text-sm text-gray-700 transition-all font-medium">
                        <span class="w-6 h-6 rounded bg-[#3b82f6] mr-3 shadow-sm"></span> Filling (Resin)
                    </button>
                    <button @click="activeTool = 'crown'" :class="activeTool === 'crown' ? 'bg-yellow-50 ring-2 ring-yellow-400 font-bold text-yellow-700' : 'hover:bg-yellow-50'" class="w-full flex items-center p-2.5 rounded-xl text-sm text-gray-700 transition-all font-medium">
                        <span class="w-6 h-6 rounded bg-[#eab308] mr-3 shadow-sm"></span> Crown
                    </button>
                    <button @click="activeTool = 'extracted'" :class="activeTool === 'extracted' ? 'bg-gray-100 ring-2 ring-gray-500 font-bold text-gray-800' : 'hover:bg-gray-100'" class="w-full flex items-center p-2.5 rounded-xl text-sm text-gray-700 transition-all font-medium">
                        <span class="w-6 h-6 rounded border-2 border-[#6b7280] flex items-center justify-center mr-3 shadow-sm"><svg class="w-4 h-4 text-[#6b7280]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></span> Extracted
                    </button>
                </div>
                
                <div class="border-t border-gray-100 pt-4">
                    <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Or Add Treatment:</label>
                    <select x-model="activeTool" class="w-full border-gray-200 rounded-xl shadow-sm focus:border-[#39D3C4] focus:ring-[#39D3C4] text-sm py-2.5 mb-1 bg-gray-50 font-medium">
                        <option value="">-- Catalog --</option>
                        <template x-for="item in treatmentCatalogs" :key="item.id">
                            <option :value="'treatment_' + item.id" x-text="`${item.name} (${item.default_price} DH)`"></option>
                        </template>
                    </select>
                    <p class="text-[10px] text-gray-400 mt-2 leading-tight text-center font-medium bg-gray-50 rounded-lg p-2">Select a tool, then click on any tooth surface.</p>
                </div>
            </div>
            <!-- End Screen View -->
