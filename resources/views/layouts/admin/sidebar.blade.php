<!-- start sidebar section -->
<div :class="{'dark text-white-dark' : $store.app.semidark}">
  <nav x-data="sidebar"
    class="sidebar fixed top-0 bottom-0 z-50 h-full min-h-screen w-[260px] shadow-[5px_0_25px_0_rgba(94,92,154,0.1)] transition-all duration-300">
    <div class="h-full bg-white dark:bg-[#0e1726]">
      <div class="flex items-center justify-between px-4 py-3">
        <a href="index.html"
          class="flex items-center main-logo shrink-0">
          <img class="ml-[5px] w-8 flex-none"
            src="{{ asset('panel/images/logo.svg') }}"
            alt="image"/>
          <span
            class="align-middle text-2xl font-semibold ltr:ml-1.5 rtl:mr-1.5 dark:text-white-light lg:inline">IMO</span>
        </a>
        <a href="javascript:;"
          class="flex items-center w-8 h-8 transition duration-300 rounded-full collapse-icon hover:bg-gray-500/10 rtl:rotate-180 dark:text-white-light dark:hover:bg-dark-light/10"
          @click="$store.app.toggleSidebar()">
          <x-icons.double-arrow-left/>
        </a>
      </div>
      <ul
        class="perfect-scrollbar relative h-[calc(100vh-80px)] space-y-0.5 overflow-y-auto overflow-x-hidden p-4 py-0 font-semibold"
        x-data="{ activeDropdown: 'dashboard' }">
        <li class="menu nav-item">
          <button type="button"
            class="nav-link group"
            :class="{'active' : activeDropdown === 'dashboard'}"
            @click="activeDropdown === 'dashboard' ? activeDropdown = null : activeDropdown = 'dashboard'">
            <div class="flex items-center">
              <x-icons.home/>
              <span
                class="text-black ltr:pl-3 rtl:pr-3 dark:text-[#506690] dark:group-hover:text-white-dark">داشبورد</span>
            </div>
            <div class="rtl:rotate-180"
              :class="{'!rotate-90' : activeDropdown === 'dashboard'}">
              <x-icons.arrow/>
            </div>
          </button>
          <ul x-cloak
            x-show="activeDropdown === 'dashboard'"
            x-collapse
            class="text-gray-500 sub-menu">
            <li>

              <a href="{{ route('panel') }}"
                class="{{ request()->is('admin') ? 'active' : '' }}">
                داشبورد
              </a>
            </li>

            <li>
              <a href="{{ route('admin.users.list') }}"
                class="{{ request()->is('admin/users*') ? 'active' : '' }}">
                کاربران
              </a>
            </li>

            <li>
              <a href="{{ route('admin.categories.list') }}"
                class="{{ request()->is('admin/categories*') ? 'active' : '' }}">
                دسته‌بندی‌ها
              </a>
            </li>

            <li>
              <a href="{{ route('admin.brand.list') }}"
                class="{{ request()->is('admin/brands*') ? 'active' : '' }}">
                برندها
              </a>

              <a href="{{ route('admin.colors.list') }}"
                class="{{ request()->is('admin/colors*') ? 'active' : '' }}">
                رنگ‌ها
              </a>

              <a href="{{ route('admin.guaranty.list') }}"
                class="{{ request()->is('admin/guaranties*') ? 'active' : '' }}">
                گارانتی‌ها
              </a>

              <a href="{{ route('admin.product.list') }}"
                class="{{ request()->is('admin/products*') ? 'active' : '' }}">
                محصولات
              </a>
            </li>

            <!-- here -->
          </ul>
        </li>
      </ul>
    </div>
  </nav>
</div>
<!-- end sidebar section -->
