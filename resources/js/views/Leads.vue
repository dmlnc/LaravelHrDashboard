<template>
    <div>
        <!-- <UserForm :visible="formVisible" :id="formId" @close="hideForm" @save="loadData" /> -->
        <a-typography-title :level="5" class="mb-40">Заявки</a-typography-title>
        <div class="mb-40">
            <a-button type="primary" class="mr-20 mb-20" @click="isArchive(false)">Показать актуальные</a-button>
            <a-button type="primary" @click="isArchive(true)">Показать архив</a-button>

            <!-- <a-button type="primary" @click="showForm(null)">Создать</a-button> -->
        </div>
        <a-table :dataSource="users" :columns="columns" :row-key="record => record.id">
            <template #customFilterDropdown="{ setSelectedKeys, selectedKeys, confirm, clearFilters, column }">
                <div>
                    <div style="padding: 8px">
                        <a-input ref="searchInput" placeholder="Поиск" :value="selectedKeys[0]" style="width: 188px; display: block" @change="e => setSelectedKeys(e.target.value ? [e.target.value] : [])" @pressEnter="handleSearch(selectedKeys, confirm, column.dataIndex)" />
                    </div>
                    <div class="ant-table-filter-dropdown-btns">
                        <!-- <a-space> -->
                        <a-button type="link" size="small" @click="handleReset(clearFilters)">
                            Reset
                        </a-button>
                        <a-button type="primary" size="small" @click="handleSearch(selectedKeys, confirm, column.dataIndex)">
                            OK
                        </a-button>
                        <!-- </a-space> -->
                    </div>
                </div>
            </template>
            <template #bodyCell="{ column, record }">
                <template v-if="column.key === 'name'">
                    <a>
                        {{ record.surname }} {{ record.name }} 
                    </a>
                </template>
                <template v-else-if="column.key === 'restaurant'">
                    <span>
                        {{ record.restaurant.name }}
                    
                    </span>
                </template>
                <template v-else-if="column.key === 'vacancy'">
                    <span>
                        {{ record.vacancy.name }}
                    </span>
                </template>
                <template v-else-if="column.key === 'age'">
                    <span>
                        {{ record.birthday }} - {{ record.age }} лет
                    </span>
                </template>
                <template v-else-if="column.key === 'phone'">
                    <span>
                        {{ record.phone}}
                    </span>
                </template>
                <template v-else-if="column.key === 'social'">
                    <span>
                        {{ record.social}}
                    </span>
                </template>
                <template v-else-if="column.key === 'created_at'">
                    <span>
                        {{ record.created_at}}
                    </span>
                </template>
                
                <template v-else-if="column.key === 'actions'">
                    <a-space>
                        <!-- <a-button size="small" type="link" @click="showForm(record.id)"><svg viewBox="64 64 896 896" data-icon="edit" width="1em" height="1em" fill="currentColor" aria-hidden="true" focusable="false" class="">
                                <path d="M257.7 752c2 0 4-.2 6-.5L431.9 722c2-.4 3.9-1.3 5.3-2.8l423.9-423.9a9.96 9.96 0 0 0 0-14.1L694.9 114.9c-1.9-1.9-4.4-2.9-7.1-2.9s-5.2 1-7.1 2.9L256.8 538.8c-1.5 1.5-2.4 3.3-2.8 5.3l-29.5 168.2a33.5 33.5 0 0 0 9.4 29.8c6.6 6.4 14.9 9.9 23.8 9.9zm67.4-174.4L687.8 215l73.3 73.3-362.7 362.6-88.9 15.7 15.6-89zM880 836H144c-17.7 0-32 14.3-32 32v36c0 4.4 3.6 8 8 8h784c4.4 0 8-3.6 8-8v-36c0-17.7-14.3-32-32-32z"></path>
                            </svg></a-button> -->
                        <a-popconfirm :title="'Уверены, что хотите ' + (archive === true ? 'удалить': 'переместить в архив') + ' ' + record.surname + ' ' + record.name + '?'" ok-text="Да" cancel-text="Нет" @confirm="deleteInstance(record.id)">
                            <a-button type="link" danger size="small">
                                <svg viewBox="64 64 896 896" data-icon="delete" width="1em" height="1em" fill="currentColor" aria-hidden="true" focusable="false" class="">
                                    <path d="M360 184h-8c4.4 0 8-3.6 8-8v8h304v-8c0 4.4 3.6 8 8 8h-8v72h72v-80c0-35.3-28.7-64-64-64H352c-35.3 0-64 28.7-64 64v80h72v-72zm504 72H160c-17.7 0-32 14.3-32 32v32c0 4.4 3.6 8 8 8h60.4l24.7 523c1.6 34.1 29.8 61 63.9 61h454c34.2 0 62.3-26.8 63.9-61l24.7-523H888c4.4 0 8-3.6 8-8v-32c0-17.7-14.3-32-32-32zM731.3 840H292.7l-24.2-512h487l-24.2 512z"></path>
                                </svg>
                            </a-button>
                        </a-popconfirm>
                    </a-space>
                </template>
            </template>
        </a-table>
    </div>
</template>
<script>
// import UserForm from '@/components/Forms/UserForm.vue'

// Bar chart for "Active Users" card.
// import CardBarChart from '../components/Cards/CardBarChart.vue' ;

// Line chart for "Sales Overview" card.
// import CardLineChart from '../components/Cards/CardLineChart.vue' ;



import { notification } from 'ant-design-vue';

export default ({
    components: {
        // UserForm
    },
    data() {
        return {
            searchText: null,
            users: [],
            formVisible: false,
            archive: false,
            formId: null,
            loading: true,
            columns: [{
                    title: 'Имя',
                    dataIndex: 'name',
                    key: 'name',
                    sorter: (a, b) => a.name.length - b.name.length,
                    customFilterDropdown: true,
                    onFilter: (value, record) => record.name.toString().toLowerCase().includes(value.toLowerCase()),
                },
                
                {
                    title: 'Ресторан',
                    dataIndex: 'restaurant',
                    key: 'restaurant',
                    // customFilterDropdown: true,
                    // onFilter: (value, record) => (record.restaurant.filter((restaurant) => { return restaurant.name == value })).length > 0
                },
                {
                    title: 'Вакансия',
                    dataIndex: 'vacancy',
                    key: 'vacancy',
                    // customFilterDropdown: true,
                    // onFilter: (value, record) => (record.vacancy.filter((vacancy) => { return vacancy.name == value })).length > 0
                },
                {
                    title: 'Возраст',
                    dataIndex: 'age',
                    key: 'age',
                },
                {
                    title: 'Телефон',
                    dataIndex: 'phone',
                    key: 'phone',
                },
                {
                    title: 'Соцсеть',
                    dataIndex: 'social',
                    key: 'social',
                },
                {
                    title: '',
                    dataIndex: 'created_at',
                    key: 'created_at',
                },
                
                {
                    title: '',
                    key: 'actions',
                },
            ],

        }
    },

    mounted() {
        this.loadData();
    },

    methods: {

        loadData() {
            this.loading = true;
            this.users = [];
            this.$axios.get('/lead?archive='+this.archive*1)
                .then(response => {
                    // console.log(response)
                    this.users = response.data.data;
                    // router.push({ name: 'Academy', params: {academy_id: } })
                })
                .catch(error => {
                    notification.error({
                        message: 'Ошибка',
                        //description: error,
                    });
                })
                .then(() => {
                    this.loading = false;
                });
        },

        deleteInstance(id) {
            this.loading = true;

            this.$axios.delete('/lead/' + id)
                .then(response => {
                    notification.success({
                        message: 'Успешно',
                    });
                })
                .catch(error => {
                    notification.error({
                        message: 'Ошибка',
                        //description: error,
                    });
                })
                .then(() => {

                    this.loadData();
                    // this.loading = false;
                });
        },

        showForm(id) {
            this.formId = id
            this.formVisible = true
        },
        hideForm() {
            this.formVisible = false;
            this.formId = null
        },

        handleSearch(selectedKeys, confirm, dataIndex) {
            confirm();
            // this.searchText = selectedKeys[0];
        },
        handleReset(clearFilters) {

            clearFilters({
                confirm: true,
            });

            this.searchText = '';
        },
        isArchive(flag){
            this.archive = flag;
            this.loadData();

        }


    }
})

</script>
<style lang="scss">
</style>
