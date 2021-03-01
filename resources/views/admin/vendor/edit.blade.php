@extends('admin.include.app')

@section('main')

    <?php
    $search_type = Request::get('type');
    $title = "점주";
    ?>

    <admin-title-box
            :show-calendar="false">
        <template slot="header">
            <span class="title-box__title">{{ $title }}</span>
        </template>
    </admin-title-box>

    <div class="content-box">
        <table class="popup-table">
            <colgroup>
                <col width="114px" />
            </colgroup>
            <tr>
                <th>상호명</th>
                <td><input type="text" class="popup-table__input" placeholder="상호명을 입력하세요" v-model="vendor.company"></td>
            </tr>
            <tr>
                <th>아이디</th>
                <td><input type="text" class="popup-table__input" v-model="user.email" readonly></td>
            </tr>
            <tr>
                <th>사업자 등록번호</th>
                <td><input type="text" class="popup-table__input" placeholder="사업자등록번호를 입력하세요" v-model="vendor.crn"></td>
            </tr>
            <tr>
                <th>이름</th>
                <td><input type="text" class="popup-table__input" placeholder="이름을 입력하세요" v-model="user.name"></td>
            </tr>
            <tr>
                <th>이메일</th>
                <td><input type="text" class="popup-table__input" placeholder="이메일을 입력하세요" v-model="vendor.email"></td>
            </tr>
            <tr>
                <th>소개</th>
                <td><textarea class="textarea" v-model="vendor.introduce"></textarea></td>
            </tr>
            <tr>
                <th>주소</th>
                <td><input type="text" class="popup-table__input" placeholder="주소를 입력하세요" v-model="vendor.address"></td>
            </tr>
            <tr>
                <th>홈페이지 URL</th>
                <td><input type="text" class="popup-table__input" placeholder="홈페이지 URL을 입력하세요" v-model="vendor.home_url"></td>
            </tr>
            <tr>
                <th>유튜브 URL</th>
                <td><input type="text" class="popup-table__input" placeholder="유튜브 URL을 입력하세요" v-model="vendor.youtube_url"></td>
            </tr>
            <tr>
                <th>페이스북 URL</th>
                <td><input type="text" class="popup-table__input" placeholder="페이스북 URL을 입력하세요" v-model="vendor.facebook_url"></td>
            </tr>
            <tr>
                <th>인스타그램 URL</th>
                <td><input type="text" class="popup-table__input" placeholder="페이스북 URL을 입력하세요" v-model="vendor.instagram_url"></td>
            </tr>
            <tr>
                <th>카카오 URL</th>
                <td><input type="text" class="popup-table__input" placeholder="카카오 URL을 입력하세요" v-model="vendor.kakaoplus_url"></td>
            </tr>
            <tr>
                <th>네이버 URL</th>
                <td><input type="text" class="popup-table__input" placeholder="네이버 URL을 입력하세요" v-model="vendor.naver_url"></td>
            </tr>
            <tr>
                <th>카피라이트</th>
                <td><input type="text" class="popup-table__input" placeholder="카피라이트를 입력하세요" v-model="vendor.copyright"></td>
            </tr>
            <tr>
                <th>대표 이미지</th>
                <td>
                    <input type="file" ref="file" id="input-file" class="upload-hidden" accept="application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" multiple="" @change="handleFileUpload()">
                </td>
            </tr>
        </table>
        <div class="table__addition">
            <div></div>
            <div>
                <button type="button" class="btn__item btn__item--red" @click="ok">저장</button>
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
                    user: {
                        id: "{{ $vendor->user->id }}",
                        name: "{{ $vendor->user->nick_name }}",
                        email: "{{ $vendor->user->email }}",
                    },
                    vendor: {
                        company: "{{ $vendor->company }}",
                        crn: "{{ $vendor->crn }}",
                        email: "{{ $vendor->email }}",
                        introduce: "{{ $vendor->introduce }}",
                        address: "{{ $vendor->address }}",
                        home_url: "{{ $vendor->home_url }}",
                        youtube_url: "{{ $vendor->youtube_url }}",
                        facebook_url: "{{ $vendor->facebook_url }}",
                        instagram_url: "{{ $vendor->instagram_url }}",
                        naver_url: "{{ $vendor->naver_url }}",
                        kakaoplus_url: "{{ $vendor->kakaoplus_url }}",
                        copyright: "{{ $vendor->copyright }}",
                        files: "{{ $vendor->files }}",
                    }
                };
            },
            components: {
            },
            created() {
            },
            computed: {
            },
            mounted(){
            },
            methods: {
                ok: function() {

                    let app = this;

                    let form = new FormData()
                    form.append('name', this.user.name);
                    form.append('company', this.vendor.company);
                    form.append('crn', this.vendor.crn);
                    form.append('email', this.vendor.email);
                    form.append('introduce', this.vendor.introduce);
                    form.append('address', this.vendor.address);
                    form.append('home_url', this.vendor.home_url);
                    form.append('naver_url', this.vendor.naver_url);
                    form.append('facebook_url', this.vendor.facebook_url);
                    form.append('kakaoplus_url', this.vendor.kakaoplus_url);
                    form.append('copyright', this.vendor.copyright);
                    form.append('files', this.vendor.files);

                    axios.post("{{ route('api.admin.vendor.update', ['vendor' => $vendor->id]) }}", form, {
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

                            console.log(response);
                        });
                },
                cancel: function() {
                    window.location = document.referrer
                },
                handleFileUpload(){
                    this.file = this.$refs.file.files[0];
                }
            }
        });
    </script>


@endsection