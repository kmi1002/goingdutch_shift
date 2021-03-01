@extends('admin.include.app')

@section('custom_style')
@endsection

@section('main')

    <?php
        $title = "";
        switch ($mode) {
            case 'create': $title = "메뉴 생성"; break;
            case 'edit': $title = "메뉴 수정"; break;
            default:    $title = "에러"; break;
        }
    ?>
    <admin-title-box
            :show-calendar="false">
        <template slot="header">
            <span class="title-box__title">{{ $title }}</span>
        </template>
    </admin-title-box>

    <div class="table-box">
        <table class="popup-table">
            <colgroup>
                <col width="114px" />
            </colgroup>
            <tr>
                <th>이름(한글)</th>
                <td><input type="text" class="popup-table__input" v-model="menu.title"></td>
            </tr>
            <tr>
                <th>이름(영문)</th>
                <td><input type="text" class="popup-table__input" v-model="menu.sub_title"></td>
            </tr>
            <tr>
                <th>소개</th>
                <td><textarea class="textarea" v-model="menu.description"></textarea></td>
            </tr>
            <tr>
                <th>유의사항</th>
                <td><textarea class="textarea" v-model="menu.caution"></textarea></td>
            </tr>
            <tr>
                <th>이미지</th>
                <td>
                    <div class="file-form">
                        <input type="text" class="file-form__name" v-model="menu.fileName" disabled="disabled">
                        <label for="input-file">업로드</label>
                        <input type="file[]" ref="file" id="input-file" class="upload-hidden" accept="image/jpeg, image/png" v-on:change="handleFileUpload()">
                    </div>
                </td>
            </tr>
            <tr>
                <th>메뉴 카테고리</th>
                <td>
                    <select class="w_130" v-model="menu.group_id" @change="changeGroup">
                        <option v-for="(_group, _index) in groups" :value="_group.id" :selected="_group.id === menu.group_id">@{{ _group.title }}</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th>원본 가격</th>
                <td><input type="text" class="popup-table__input" v-model="menu.original_price"></td>
            </tr>
            <tr>
                <th>할인 가격</th>
                <td><input type="text" class="popup-table__input" v-model="menu.discount_price"></td>
            </tr>
            <tr>
                <th>할인 퍼센트(%)</th>
                <td><input type="text" class="popup-table__input" v-model="menu.discount_percent"></td>
            </tr>
            <tr>
                <th>최종 가격</th>
                <td>@{{ calcPrice(menu.original_price, menu.discount_price, menu.discount_percent) }}</td>
            </tr>
        </table>
        <div class="table__addition">
            <div></div>
            <div>
                <button type="button" class="btn__item--red" @click="ok">저장</button>
                <button type="button" class="btn__item" @click="cancel">취소</button>
            </div>
            <div></div>
        </div>
    </div>
@endsection

@section('bottom_scripts')
    <script>
        new Vue({
            el: '#wrap',
            data() {
                return {
                    vendor_id: {{ $vendor_id ?? 0 }},
                    id: {{ $menu_id ?? 0 }},
                    mode: '{{ $mode }}',
                    menu: {
                        title: '',
                        sub_title: '',
                        description: '',
                        caution: '',
                        file: '',
                        fileName: '파일선택',
                        group_id: 0,
                        original_price: 0,
                        discount_price: 0,
                        discount_percent: 0,
                    },
                    old: this.menu,
                    groups: {},
                    options: {},
                    error: null,
                };
            },
            created() {
                this.selectGroup();

                if (this.mode === 'edit') {
                    this.select();
                }
            },
            methods: {
                ok() {
                    let app = this;

                    let form = new FormData()
                    form.append('vendor_id', this.vendor_id);
                    form.append('title', this.menu.title);
                    form.append('sub_title', this.menu.sub_title);
                    form.append('description', this.menu.description);
                    form.append('caution', this.menu.caution);
                    form.append('original_price', this.menu.original_price);
                    form.append('discount_price', this.menu.discount_price);
                    form.append('discount_percent', this.menu.discount_percent);
                    form.append('group_id', this.menu.group_id);

                    if (this.id == 0) {
                        this.create(form);
                    } else {
                        this.update(form);
                    }
                },
                cancel() {
                    window.location = document.referrer
                },
                create(form) {
                    let app = this;

                    axios.post(`/api/admin/vendor/${this.vendor_id}/menu`, form)
                        .then(function (response) {

                            if (response.status == 201) {
                                window.location = document.referrer
                            } else {
                                alert('이메일이 중복되었습니다');
                            }
                        })
                        .catch(function (response) {
                            app.error = response;
                        });
                },
                select() {
                    let app = this;

                    axios.get(`/api/admin/vendor/${this.vendor_id}/menu/${this.id}`)
                        .then(function (response) {
                            app.menu = response.data.data;
                        })
                        .catch(function (response) {
                            app.error = response;
                        });
                },
                update(form) {
                    if (this.menu === this.old) {
                        alert('이전 데이터랑 값이 같습니다.')
                        return;
                    }

                    let app = this;

                    axios.post(`/api/admin/vendor/${this.vendor_id}/menu/${this.id}`, form, {
                        headers: {
                            'X-HTTP-Method-Override': 'PUT'
                        }
                    })
                        .then(function (response) {

                            if (response.status == 200) {
                                window.location = document.referrer
                            } else {
                                alert('이메일이 중복되었습니다');
                            }
                        })
                        .catch(function (response) {
                            app.error = response;
                        });
                },
                selectGroup() {
                    let app = this;

                    axios.get(`/api/admin/vendor/${this.vendor_id}/menu/group`)
                        .then(function (response) {
                            app.groups = response.data.data;
                        })
                        .catch(function (response) {
                            app.error = response;
                        });
                },
                changeGroup: function() {
                },
            }
        });
    </script>
@endsection