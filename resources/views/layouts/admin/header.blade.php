<div class="main-content">
  <!-- start header section -->
  <header :class="{'dark' : $store.app.semidark && $store.app.menu === 'horizontal'}">
    <div class="shadow-sm">
      <div class="relative flex w-full items-center bg-white px-5 py-2.5 dark:bg-[#0e1726]">
        <div class="flex items-center justify-between horizontal-logo ltr:mr-2 rtl:ml-2 lg:hidden">
          <a href="index.html"
            class="flex items-center main-logo shrink-0">
            <img class="inline w-8 ltr:-ml-1 rtl:-mr-1"
              src="{{ asset('panel/images/logo.svg') }}"
              alt="image"/>
          </a>

          <a href="javascript:;"
            class="collapse-icon flex flex-none rounded-full bg-white-light/40 p-2 hover:bg-white-light/90 hover:text-primary ltr:ml-2 rtl:mr-2 dark:bg-dark/40 dark:text-[#d0d2d6] dark:hover:bg-dark/60 dark:hover:text-primary lg:hidden"
            @click="$store.app.toggleSidebar()">
            <x-icons.menu/>
          </a>
        </div>

        <div x-data="header"
          class="flex items-center space-x-1.5 ltr:ml-auto rtl:mr-auto rtl:space-x-reverse dark:text-[#d0d2d6] sm:flex-1 ltr:sm:ml-0 sm:rtl:mr-0 lg:space-x-2">
          <div class="sm:ltr:mr-auto sm:rtl:ml-auto"
            x-data="{ search: false }"
            @click.outside="search = false">
            <form
              class="absolute inset-x-0 z-10 hidden mx-4 -translate-y-1/2 top-1/2 sm:relative sm:top-0 sm:mx-0 sm:block sm:translate-y-0"
              :class="{'!block' : search}"
              @submit.prevent="search = false">
              <div class="relative">
                <input type="text"
                  class="bg-gray-100 peer form-input placeholder:tracking-widest ltr:pl-9 ltr:pr-9 rtl:pr-9 rtl:pl-9 sm:bg-transparent ltr:sm:pr-4 rtl:sm:pl-4"
                  placeholder="جستجو"/>
                <button type="button"
                  class="absolute inset-0 appearance-none h-9 w-9 peer-focus:text-primary ltr:right-auto rtl:left-auto">
                  <x-icons.search/>
                </button>
                <button type="button"
                  class="absolute block -translate-y-1/2 top-1/2 hover:opacity-80 ltr:right-2 rtl:left-2 sm:hidden"
                  @click="search = false">
                  <x-icons.close/>
                </button>
              </div>
            </form>
            <button type="button"
              class="p-2 rounded-full search_btn bg-white-light/40 hover:bg-white-light/90 dark:bg-dark/40 dark:hover:bg-dark/60 sm:hidden"
              @click="search = ! search">
              <x-icons.search/>
            </button>
          </div>
          <div>
            <a href="#"
              x-cloak
              x-show="$store.app.theme === 'light'"
              class="flex items-center p-2 rounded-full bg-white-light/40 hover:bg-white-light/90 hover:text-primary dark:bg-dark/40 dark:hover:bg-dark/60"
              @click="$store.app.toggleTheme('dark')">
              <x-icons.light-mode/>
            </a>
            <a href="#"
              x-cloak
              x-show="$store.app.theme === 'dark'"
              class="flex items-center p-2 rounded-full bg-white-light/40 hover:bg-white-light/90 hover:text-primary dark:bg-dark/40 dark:hover:bg-dark/60"
              @click="$store.app.toggleTheme('system')">
              <x-icons.dark-mode/>
            </a>
            <a href="#"
              x-cloak
              x-show="$store.app.theme === 'system'"
              class="flex items-center p-2 rounded-full bg-white-light/40 hover:bg-white-light/90 hover:text-primary dark:bg-dark/40 dark:hover:bg-dark/60"
              @click="$store.app.toggleTheme('light')">
              <x-icons.system-mode/>
            </a>
          </div>

          <div class="dropdown"
            x-data="dropdown"
            @click.outside="open = false">
            <a href="javascript:;"
              class="relative block p-2 rounded-full bg-white-light/40 hover:bg-white-light/90
                  hover:text-primary dark:bg-dark/40 dark:hover:bg-dark/60"
              @click="toggle">
              <x-icons.notification/>

              <span class="absolute top-0 flex w-3 h-3 ltr:right-0 rtl:left-0"><span
                  class="absolute -top-[3px] inline-flex h-full w-full animate-ping rounded-full bg-success/50 opacity-75 ltr:-left-[3px] rtl:-right-[3px]"></span>
                    <span
                      class="relative inline-flex h-[6px] w-[6px] rounded-full bg-success"></span>
                    </span>
            </a>
            <ul x-cloak
              x-show="open"
              x-transition
              x-transition.duration.300ms
              class="top-11 w-[300px] divide-y !py-0 text-dark ltr:-right-2 rtl:-left-2 dark:divide-white/10 dark:text-white-dark sm:w-[350px]">
              <li>
                <div
                  class="flex items-center justify-between px-4 py-2 font-semibold hover:!bg-transparent">
                  <h4 class="text-lg">نوتیفیکیشن</h4>
                  <template x-if="notifications.length">
                        <span class="badge bg-primary/80"
                          x-text="notifications.length + 'New'">
                        </span>
                  </template>
                </div>
              </li>
              <template x-for="notification in notifications">
                <li class="dark:text-white-light/90">
                  <div class="flex items-center px-4 py-2 group"
                    @click.self="toggle">
                    <div class="grid rounded place-content-center">
                      <div class="relative w-12 h-12">
                        <img class="object-cover w-12 h-12 rounded-full"
                          alt="image"/>
                        <span
                          class="absolute right-[6px] bottom-0 block h-2 w-2 rounded-full bg-success"></span>
                      </div>
                    </div>
                    <div class="flex flex-auto ltr:pl-3 rtl:pr-3">
                      <div class="ltr:pr-3 rtl:pl-3">
                        <h6 x-html="notification.message"></h6>
                        <span class="block text-xs font-normal dark:text-gray-500"
                          x-text="notification.time">
                            </span>
                      </div>
                      <button type="button"
                        class="opacity-0 text-neutral-300 hover:text-danger group-hover:opacity-100 ltr:ml-auto rtl:mr-auto"
                        @click="removeNotification(notification.id)">
                        <x-icons.close/>
                      </button>
                    </div>
                  </div>
                </li>
              </template>
              <template x-if="notifications.length">
                <li>
                  <div class="p-4">
                    <button class="block w-full btn btn-primary btn-small"
                      @click="toggle">همه
                                      نوتیفیکیشن ها را بخوانید
                    </button>
                  </div>
                </li>
              </template>
              <template x-if="!notifications.length">
                <li>
                  <div
                    class="!grid min-h-[200px] place-content-center text-lg hover:!bg-transparent">
                    <div
                      class="mx-auto mb-4 rounded-full text-primary ring-4 ring-primary/30">
                      <x-icons.alert/>
                    </div>
                    اطلاعاتی موجود نیست.
                  </div>
                </li>
              </template>
            </ul>
          </div>
          <div class="flex-shrink-0 dropdown"
            x-data="dropdown"
            @click.outside="open = false">
            <a href="javascript:;"
              class="relative group"
              @click="toggle()">
                  <span><img
                      class="object-cover rounded-full h-9 w-9 saturate-50 group-hover:saturate-100"
                      src="{{ asset('panel/images/user-profile.jpeg') }}"
                      alt="image"/>
                  </span>
            </a>
            <ul x-cloak
              x-show="open"
              x-transition
              x-transition.duration.300ms
              class="top-11 w-[230px] !py-0 font-semibold text-dark ltr:right-0 rtl:left-0 dark:text-white-dark dark:text-white-light/90">
              <li>
                <div class="flex items-center px-4 py-4">
                  <div class="flex-none">
                    <img class="object-cover w-10 h-10 rounded-md"
                      src="{{ asset('panel/images/user-profile.jpeg') }}"
                      alt="image"/>
                  </div>
                  <div class="ltr:pl-4 rtl:pr-4">
                    <h4 class="text-base">
                      جان
                      دو<span
                        class="px-1 text-xs rounded bg-success-light text-success ltr:ml-2 rtl:ml-2">Pro</span>
                    </h4>
                    <a class="text-black/60 hover:text-primary dark:text-dark-light/60 dark:hover:text-white"
                      href="javascript:;">johndoe@gmail.com</a>
                  </div>
                </div>
              </li>
              <li>
                <a href="users-profile.html"
                  class="dark:hover:text-white"
                  @click="toggle">
                  <x-icons.user/>
                  پروفایل</a>
              </li>
              <li>
                <a href="apps-mailbox.html"
                  class="dark:hover:text-white"
                  @click="toggle">
                  <x-icons.email/>
                  صندوق ورودی</a>
              </li>
              <li>
                <a href="auth-boxed-lockscreen.html"
                  class="dark:hover:text-white"
                  @click="toggle">
                  <x-icons.lock/>
                  صفحه قفل</a>
              </li>
              <li class="border-t border-white-light dark:border-white-light/10">
                <a href="auth-boxed-signin.html"
                  class="!py-3 text-danger"
                  @click="toggle">
                  <x-icons.exit/>
                  خروج از سیستم
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>


    </div>
  </header>
  <!-- end header section -->
