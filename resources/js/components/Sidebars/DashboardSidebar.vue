<template>
    <!-- Main Sidebar -->
    <a-layout-sider collapsible class="sider-primary" breakpoint="lg" collapsed-width="0" width="250px" :collapsed="sidebarCollapsed" @collapse="$emit('toggleSidebar', ! sidebarCollapsed)" :trigger="null" :class="['ant-layout-sider-' + sidebarColor, 'ant-layout-sider-' + sidebarTheme]" theme="light" :style="{ backgroundColor: 'transparent',}">
        <div class="brand text-center">
            <div class="mt-10">Менеджер вакансий</div>
        </div>
        <hr>
        <!-- Sidebar Navigation Menu -->
        <a-menu theme="light" mode="inline">
            <a-menu-item>
                <router-link to="/admin/dashboard">
                    <span class="icon">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.7071 2.29289C10.3166 1.90237 9.68342 1.90237 9.29289 2.29289L2.29289 9.29289C1.90237 9.68342 1.90237 10.3166 2.29289 10.7071C2.68342 11.0976 3.31658 11.0976 3.70711 10.7071L4 10.4142V17C4 17.5523 4.44772 18 5 18H7C7.55228 18 8 17.5523 8 17V15C8 14.4477 8.44772 14 9 14H11C11.5523 14 12 14.4477 12 15V17C12 17.5523 12.4477 18 13 18H15C15.5523 18 16 17.5523 16 17V10.4142L16.2929 10.7071C16.6834 11.0976 17.3166 11.0976 17.7071 10.7071C18.0976 10.3166 18.0976 9.68342 17.7071 9.29289L10.7071 2.29289Z" fill="#ffffff"></path>
                        </svg>
                    </span>
                    <span class="label">Главная</span>
                </router-link>
            </a-menu-item>
            <a-menu-item>
                <router-link to="/admin/restaurants" :class="{'router-link-active': $route.path.startsWith('/admin/restaurants')}">
                    <span class="icon">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 4C3 3.44772 3.44772 3 4 3H16C16.5523 3 17 3.44772 17 4V6C17 6.55228 16.5523 7 16 7H4C3.44772 7 3 6.55228 3 6V4Z" fill="#111827" />
                            <path d="M3 10C3 9.44771 3.44772 9 4 9H10C10.5523 9 11 9.44771 11 10V16C11 16.5523 10.5523 17 10 17H4C3.44772 17 3 16.5523 3 16V10Z" fill="#111827" />
                            <path d="M14 9C13.4477 9 13 9.44771 13 10V16C13 16.5523 13.4477 17 14 17H16C16.5523 17 17 16.5523 17 16V10C17 9.44771 16.5523 9 16 9H14Z" fill="#111827" />
                        </svg>
                    </span>
                    <span class="label">Рестораны</span>
                </router-link>
            </a-menu-item>
            <a-menu-item>
                <router-link to="/admin/vacancies" :class="{'router-link-active': $route.path.startsWith('/admin/vacancies')}">
                    <span class="icon">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 2C8.44772 2 8 2.44772 8 3C8 3.55228 8.44772 4 9 4H11C11.5523 4 12 3.55228 12 3C12 2.44772 11.5523 2 11 2H9Z" fill="#111827" />
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M4 5C4 3.89543 4.89543 3 6 3C6 4.65685 7.34315 6 9 6H11C12.6569 6 14 4.65685 14 3C15.1046 3 16 3.89543 16 5V16C16 17.1046 15.1046 18 14 18H6C4.89543 18 4 17.1046 4 16V5ZM7 9C6.44772 9 6 9.44772 6 10C6 10.5523 6.44772 11 7 11H7.01C7.56228 11 8.01 10.5523 8.01 10C8.01 9.44772 7.56228 9 7.01 9H7ZM10 9C9.44772 9 9 9.44772 9 10C9 10.5523 9.44772 11 10 11H13C13.5523 11 14 10.5523 14 10C14 9.44772 13.5523 9 13 9H10ZM7 13C6.44772 13 6 13.4477 6 14C6 14.5523 6.44772 15 7 15H7.01C7.56228 15 8.01 14.5523 8.01 14C8.01 13.4477 7.56228 13 7.01 13H7ZM10 13C9.44772 13 9 13.4477 9 14C9 14.5523 9.44772 15 10 15H13C13.5523 15 14 14.5523 14 14C14 13.4477 13.5523 13 13 13H10Z" fill="#111827" />
                        </svg>
                    </span>
                    <span class="label">Вакансии</span>
                </router-link>
            </a-menu-item>
            <!-- <a-menu-item>
                <router-link to="/admin/users" :class="{'router-link-active': $route.path.startsWith('/admin/users')}">
                    <span class="icon">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 6C9 7.65685 7.65685 9 6 9C4.34315 9 3 7.65685 3 6C3 4.34315 4.34315 3 6 3C7.65685 3 9 4.34315 9 6Z" fill="#111827" />
                            <path d="M17 6C17 7.65685 15.6569 9 14 9C12.3431 9 11 7.65685 11 6C11 4.34315 12.3431 3 14 3C15.6569 3 17 4.34315 17 6Z" fill="#111827" />
                            <path d="M12.9291 17C12.9758 16.6734 13 16.3395 13 16C13 14.3648 12.4393 12.8606 11.4998 11.6691C12.2352 11.2435 13.0892 11 14 11C16.7614 11 19 13.2386 19 16V17H12.9291Z" fill="#111827" />
                            <path d="M6 11C8.76142 11 11 13.2386 11 16V17H1V16C1 13.2386 3.23858 11 6 11Z" fill="#111827" />
                        </svg>
                    </span>
                    <span class="label">Пользователи</span>
                </router-link>
            </a-menu-item> -->

            <a-menu-item>
                <router-link to="/admin/landing" :class="{'router-link-active': $route.path.startsWith('/admin/landing')}">
                    <span class="icon">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 4C3 3.44772 3.44772 3 4 3H16C16.5523 3 17 3.44772 17 4V6C17 6.55228 16.5523 7 16 7H4C3.44772 7 3 6.55228 3 6V4Z" fill="#111827" />
                            <path d="M3 10C3 9.44771 3.44772 9 4 9H10C10.5523 9 11 9.44771 11 10V16C11 16.5523 10.5523 17 10 17H4C3.44772 17 3 16.5523 3 16V10Z" fill="#111827" />
                            <path d="M14 9C13.4477 9 13 9.44771 13 10V16C13 16.5523 13.4477 17 14 17H16C16.5523 17 17 16.5523 17 16V10C17 9.44771 16.5523 9 16 9H14Z" fill="#111827" />
                        </svg>
                    </span>
                    <span class="label">Landing</span>
                </router-link>
            </a-menu-item>

            <a-menu-item>
                <router-link to="/admin/leads" :class="{'router-link-active': $route.path.startsWith('/admin/leads')}">
                    <span class="icon">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 6C9 7.65685 7.65685 9 6 9C4.34315 9 3 7.65685 3 6C3 4.34315 4.34315 3 6 3C7.65685 3 9 4.34315 9 6Z" fill="#111827" />
                            <path d="M17 6C17 7.65685 15.6569 9 14 9C12.3431 9 11 7.65685 11 6C11 4.34315 12.3431 3 14 3C15.6569 3 17 4.34315 17 6Z" fill="#111827" />
                            <path d="M12.9291 17C12.9758 16.6734 13 16.3395 13 16C13 14.3648 12.4393 12.8606 11.4998 11.6691C12.2352 11.2435 13.0892 11 14 11C16.7614 11 19 13.2386 19 16V17H12.9291Z" fill="#111827" />
                            <path d="M6 11C8.76142 11 11 13.2386 11 16V17H1V16C1 13.2386 3.23858 11 6 11Z" fill="#111827" />
                        </svg>
                    </span>
                    <span class="label">Заявки</span>
                </router-link>
            </a-menu-item>

            
            <!-- <a-menu-item>
              <router-link to="/posts">
                      <span class="icon">
                          <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path d="M10.7071 2.29289C10.3166 1.90237 9.68342 1.90237 9.29289 2.29289L2.29289 9.29289C1.90237 9.68342 1.90237 10.3166 2.29289 10.7071C2.68342 11.0976 3.31658 11.0976 3.70711 10.7071L4 10.4142V17C4 17.5523 4.44772 18 5 18H7C7.55228 18 8 17.5523 8 17V15C8 14.4477 8.44772 14 9 14H11C11.5523 14 12 14.4477 12 15V17C12 17.5523 12.4477 18 13 18H15C15.5523 18 16 17.5523 16 17V10.4142L16.2929 10.7071C16.6834 11.0976 17.3166 11.0976 17.7071 10.7071C18.0976 10.3166 18.0976 9.68342 17.7071 9.29289L10.7071 2.29289Z" fill="#ffffff"></path>
                          </svg>
                      </span>
                <span class="label">Новости</span>
              </router-link>
            </a-menu-item> -->
            <a-menu-item class="menu-item-header">
                <hr>
            </a-menu-item>
            <!-- <a-menu-item>
                    <router-link to="/profile">
                        <span class="icon">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M18 10C18 14.4183 14.4183 18 10 18C5.58172 18 2 14.4183 2 10C2 5.58172 5.58172 2 10 2C14.4183 2 18 5.58172 18 10ZM12 7C12 8.10457 11.1046 9 10 9C8.89543 9 8 8.10457 8 7C8 5.89543 8.89543 5 10 5C11.1046 5 12 5.89543 12 7ZM9.99993 11C7.98239 11 6.24394 12.195 5.45374 13.9157C6.55403 15.192 8.18265 16 9.99998 16C11.8173 16 13.4459 15.1921 14.5462 13.9158C13.756 12.195 12.0175 11 9.99993 11Z" fill="#111827"/>
                            </svg>
                        </span>
                        <span class="label">Profile</span>
                    </router-link>
                </a-menu-item> -->
            <a-menu-item>
                <a @click.prevent="logOut">
                    <span class="icon">
                        <svg width="20" height="20" version="1.1" viewBox="0 0 490.3 490.3" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
                            <path d="m0 121.05v248.2c0 34.2 27.9 62.1 62.1 62.1h200.6c34.2 0 62.1-27.9 62.1-62.1v-40.2c0-6.8-5.5-12.3-12.3-12.3s-12.3 5.5-12.3 12.3v40.2c0 20.7-16.9 37.6-37.6 37.6h-200.5c-20.7 0-37.6-16.9-37.6-37.6v-248.2c0-20.7 16.9-37.6 37.6-37.6h200.6c20.7 0 37.6 16.9 37.6 37.6v40.2c0 6.8 5.5 12.3 12.3 12.3s12.3-5.5 12.3-12.3v-40.2c0-34.2-27.9-62.1-62.1-62.1h-200.7c-34.2 0-62.1 27.8-62.1 62.1z" />
                            <path d="m385.4 337.65c2.4 2.4 5.5 3.6 8.7 3.6s6.3-1.2 8.7-3.6l83.9-83.9c4.8-4.8 4.8-12.5 0-17.3l-83.9-83.9c-4.8-4.8-12.5-4.8-17.3 0s-4.8 12.5 0 17.3l63 63h-229.9c-6.8 0-12.3 5.5-12.3 12.3s5.5 12.3 12.3 12.3h229.8l-63 63c-4.8 4.7-4.8 12.5 0 17.2z" />
                        </svg>
                    </span>
                    <span class="label">Выйти</span>
                </a>
            </a-menu-item>
        </a-menu>
        <!-- / Sidebar Navigation Menu -->
        <!-- Sidebar Footer -->
        <!-- <div class="aside-footer">
            <div class="footer-box">
                <span class="icon">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 4C3 3.44772 3.44772 3 4 3H16C16.5523 3 17 3.44772 17 4V6C17 6.55228 16.5523 7 16 7H4C3.44772 7 3 6.55228 3 6V4Z" fill="#111827" />
                        <path d="M3 10C3 9.44771 3.44772 9 4 9H10C10.5523 9 11 9.44771 11 10V16C11 16.5523 10.5523 17 10 17H4C3.44772 17 3 16.5523 3 16V10Z" fill="#111827" />
                        <path d="M14 9C13.4477 9 13 9.44771 13 10V16C13 16.5523 13.4477 17 14 17H16C16.5523 17 17 16.5523 17 16V10C17 9.44771 16.5523 9 16 9H14Z" fill="#111827" />
                    </svg>
                </span>
                <h6>Нужна помощь?</h6>
                <p>Посмотрите нашу документацию</p>
                <a-button type="primary" href="/" block target="_blank">
                    Документация
                </a-button>
            </div>
        </div> -->
        <!-- / Sidebar Footer -->
    </a-layout-sider>
    <!-- / Main Sidebar -->
</template>
<script>
import AuthUtil from '@/libs/auth/auth';


export default ({
    props: {
        // Sidebar collapsed status.
        sidebarCollapsed: {
            type: Boolean,
            default: false,
        },

        // Main sidebar color.
        sidebarColor: {
            type: String,
            default: "primary",
        },

        // Main sidebar theme : light, white, dark.
        sidebarTheme: {
            type: String,
            default: "light",
        },
    },
    data() {
        return {
            // sidebarCollapsedModel: this.sidebarCollapsed,
        }
    },


    methods: {
        logOut(){
            AuthUtil.resetAuth()
            this.$router.push('/sign-in')
        }
    }
})

</script>
