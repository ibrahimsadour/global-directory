<div class="fixed bottom-0 left-0 z-50 w-full h-16 bg-white border-t border-gray-200 dark:bg-gray-700 dark:border-gray-600 md:hidden">
    <div class="grid h-full max-w-lg grid-cols-5 mx-auto">
        {{-- الرئيسية --}}
        <a href="{{ url('/') }}"
            class="inline-flex flex-col items-center justify-center px-5 rounded-s-full hover:bg-gray-50 dark:hover:bg-gray-800 group">
            
            <svg class="w-5 h-5 mb-1 
                        @if (Request::is('/')) text-blue-600 dark:text-blue-500 
                        @else text-gray-500 dark:text-gray-400 
                        @endif" 
                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
            </svg>

            <span class="text-xs 
                        @if (Request::is('/')) text-blue-600 
                        @else text-gray-700 
                        @endif">
                الرئيسية
            </span>
        </a>
        <div id="tooltip-home" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
            Home
            <div class="tooltip-arrow" data-popper-arrow></div>
        </div>

        <button data-tooltip-target="tooltip-wallet" type="button" class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 dark:hover:bg-gray-800 group">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mb-1 text-gray-500 group-hover:text-blue-600" viewBox="0 0 25 24" fill="currentColor">
                <path d="M8.27996 3.52439C8.06996 3.69439 7.82996 3.94439 7.63996 4.32439L2.29996 13.5944C1.57996 14.8344 1.64996 16.3244 2.47996 17.4844C3.23996 18.5444 4.44996 19.1144 5.72996 19.0244L5.75996 19.1844C6.10996 20.8344 7.59996 21.9744 9.24996 21.9744C9.48996 21.9744 9.72996 21.9544 9.96996 21.9044L11.75 21.5444C12.69 21.3544 13.49 20.8044 14.01 20.0044C14.52 19.2144 14.7 18.2844 14.51 17.3844L14.46 17.1044L17.3 16.7844C17.88 16.7744 18.41 16.5944 18.86 16.2344C19.23 15.9444 19.68 15.3844 19.78 14.3844C19.97 12.5144 18.79 9.81439 16.71 7.31439C14.08 4.19439 10.34 1.86439 8.27996 3.52439ZM12.33 18.9244C12.1 19.2744 11.75 19.5144 11.34 19.5944L9.56996 19.9544C8.72996 20.1244 7.87996 19.5844 7.70996 18.7744L7.67996 18.6244L12.48 17.4644L12.55 17.7944C12.63 18.1744 12.55 18.5744 12.33 18.9144V18.9244ZM17.6 14.6944C17.52 14.7644 17.4 14.7944 17.24 14.7944H17.19C16.23 14.7844 14.07 13.6744 11.96 11.1444C10.01 8.81439 9.23996 6.61439 9.33996 5.55439C9.35996 5.38439 9.39996 5.17439 9.52996 5.07439C9.61996 5.00439 9.74996 4.97439 9.91996 4.97439C10.88 4.97439 13.04 6.07439 15.16 8.61439C17.11 10.9444 17.88 13.1444 17.78 14.2044C17.76 14.3744 17.72 14.5844 17.59 14.6844L17.6 14.6944Z" fill="currentColor"/>
                <path d="M15.64 4.10439C15.75 4.14439 15.86 4.16439 15.97 4.16439C16.38 4.16439 16.77 3.90439 16.92 3.49439L17.33 2.32439C17.51 1.80439 17.23 1.23439 16.71 1.05439C16.19 0.874388 15.62 1.15439 15.44 1.67439L15.03 2.84439C14.85 3.36439 15.13 3.93439 15.65 4.11439L15.64 4.10439Z" fill="currentColor"/>
                <path d="M21.6 5.42439C21.99 5.03439 21.99 4.40439 21.6 4.01439C21.21 3.62439 20.58 3.62439 20.19 4.01439L19.41 4.79439C19.02 5.18439 19.02 5.81439 19.41 6.20439C19.61 6.39439 19.86 6.49439 20.12 6.49439C20.38 6.49439 20.63 6.39439 20.83 6.20439L21.61 5.42439H21.6Z" fill="currentColor"/>
                <path d="M22.85 9.41439H21.68C21.13 9.41439 20.68 9.86439 20.68 10.4144C20.68 10.9644 21.13 11.4144 21.68 11.4144H22.85C23.4 11.4144 23.85 10.9644 23.85 10.4144C23.85 9.86439 23.4 9.41439 22.85 9.41439Z" fill="currentColor"/>
            </svg>
            <span class="text-xs text-gray-700 group-hover:text-blue-600">اعلانات</span>
        </button>
        <div id="tooltip-bookmark" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
            اعلانات
            <div class="tooltip-arrow" data-popper-arrow></div>
        </div>
        <div class="flex items-center justify-center">
            <button data-tooltip-target="tooltip-new" type="button" class="inline-flex items-center justify-center w-10 h-10 font-medium bg-blue-600 rounded-full hover:bg-blue-700 group focus:ring-4 focus:ring-blue-300 focus:outline-none dark:focus:ring-blue-800">
                <svg class="w-4 h-4 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
                </svg>
                <span class="sr-only">New item</span>
            </button>
        </div>
        <div id="tooltip-new" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
            Create new item
            <div class="tooltip-arrow" data-popper-arrow></div>
        </div>
        
        {{-- الأقسام --}}
        <a href="{{ route('categories.index') }}"
            class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 dark:hover:bg-gray-800 group">

            <svg xmlns="http://www.w3.org/2000/svg"
                class="w-5 h-5 mb-1
                    @if (Request::is('categories') || Request::is('categories/*'))
                        text-blue-600 dark:text-blue-500
                    @else
                        text-gray-500 dark:text-gray-400
                    @endif
                    group-hover:text-blue-600 dark:group-hover:text-blue-500"
                viewBox="0 0 25 24" fill="currentColor">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M2.19995 6.5C2.19995 4.01472 4.21467 2 6.69995 2C9.18523 2 11.2 4.01472 11.2 6.5C11.2 8.98528 9.18523 11 6.69995 11C4.21467 11 2.19995 8.98528 2.19995 6.5ZM6.69995 4C5.31924 4 4.19995 5.11929 4.19995 6.5C4.19995 7.88071 5.31924 9 6.69995 9C8.08066 9 9.19995 7.88071 9.19995 6.5C9.19995 5.11929 8.08066 4 6.69995 4ZM13.2 6.5C13.2 4.01472 15.2147 2 17.7 2C20.1852 2 22.2 4.01472 22.2 6.5C22.2 8.98528 20.1852 11 17.7 11C15.2147 11 13.2 8.98528 13.2 6.5ZM17.7 4C16.3192 4 15.2 5.11929 15.2 6.5C15.2 7.88071 16.3192 9 17.7 9C19.0807 9 20.2 7.88071 20.2 6.5C20.2 5.11929 19.0807 4 17.7 4ZM2.19995 17.5C2.19995 15.0147 4.21467 13 6.69995 13C9.18523 13 11.2 15.0147 11.2 17.5C11.2 19.9853 9.18523 22 6.69995 22C4.21467 22 2.19995 19.9853 2.19995 17.5ZM6.69995 15C5.31924 15 4.19995 16.1193 4.19995 17.5C4.19995 18.8807 5.31924 20 6.69995 20C8.08066 20 9.19995 18.8807 9.19995 17.5C9.19995 16.1193 8.08066 15 6.69995 15ZM13.2 17.5C13.2 15.0147 15.2147 13 17.7 13C20.1852 13 22.2 15.0147 22.2 17.5C22.2 19.9853 20.1852 22 17.7 22C15.2147 22 13.2 19.9853 13.2 17.5ZM17.7 15C16.3192 15 15.2 16.1193 15.2 17.5C15.2 18.8807 16.3192 20 17.7 20C19.0807 20 20.2 18.8807 20.2 17.5C20.2 16.1193 19.0807 15 17.7 15Z"/>
            </svg>

            <span class="text-xs
                        @if (Request::is('categories') || Request::is('categories/*'))
                            text-blue-600
                        @else
                            text-gray-700
                        @endif">
                الأقسام
            </span>
        </a>
        <div id="tooltip-categories" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
            الأقسام
            <div class="tooltip-arrow" data-popper-arrow></div>
        </div>


        <button data-tooltip-target="tooltip-profile" type="button" class="inline-flex flex-col items-center justify-center px-5 rounded-e-full hover:bg-gray-50 dark:hover:bg-gray-800 group">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mb-1 text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-500" viewBox="0 0 25 24" fill="currentColor">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M12.3999 4C10.743 4 9.3999 5.34315 9.3999 7C9.3999 8.65685 10.743 10 12.3999 10C14.0568 10 15.3999 8.65685 15.3999 7C15.3999 5.34315 14.0568 4 12.3999 4ZM7.3999 7C7.3999 4.23858 9.63848 2 12.3999 2C15.1613 2 17.3999 4.23858 17.3999 7C17.3999 9.76142 15.1613 12 12.3999 12C9.63848 12 7.3999 9.76142 7.3999 7ZM8.3999 16C6.74305 16 5.3999 17.3431 5.3999 19C5.3999 19.5523 5.84762 20 6.3999 20H18.3999C18.9522 20 19.3999 19.5523 19.3999 19C19.3999 17.3431 18.0568 16 16.3999 16H8.3999ZM3.3999 19C3.3999 16.2386 5.63848 14 8.3999 14H16.3999C19.1613 14 21.3999 16.2386 21.3999 19C21.3999 20.6569 20.0568 22 18.3999 22H6.3999C4.74305 22 3.3999 20.6569 3.3999 19Z" fill="currentColor"/>
            </svg>
            <span class="text-xs text-gray-700 group-hover:text-blue-600">حسابي</span>
        </button>
        <div id="tooltip-profile" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
            حسابي
            <div class="tooltip-arrow" data-popper-arrow></div>
        </div>
    </div>
</div>
