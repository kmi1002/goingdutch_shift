@extends('admin.include.app')

@section('custom_style')
    <!-- Include external CSS. -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.css">

    <!-- Include Editor style. -->
    <link href='https://cdn.jsdelivr.net/npm/froala-editor@2.9.3/css/froala_editor.min.css' rel='stylesheet' type='text/css' />
    <link href='https://cdn.jsdelivr.net/npm/froala-editor@2.9.3/css/froala_style.min.css' rel='stylesheet' type='text/css' />

@endsection

@section('main')

    <?php
    $type = Request::get('type') ?? 'notice';

    $title = "";
    switch ($type) {
        case 'faq': $title = "도움말"; break;
        default: $title = "공지사항"; break;
    }
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
                <th>플랫폼</th>
                <td>
                    <select v-model="filter.platform">
                        <option value="">플랫폼</option>
                        <option value="web">Web</option>
                        <option value="ios">iOS</option>
                        <option value="android">Android</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th>언어</th>
                <td>
                    <select v-model="filter.language">
                        <option value="">언어</option>
                        <option value="ko">한국어</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th>제목</th>
                <td>
                    <input type="text" class="popup-table__input" v-model="article.title">
                </td>
            </tr>
            <tr>
                <th>내용</th>
                <td>
                    <froala :tag="'textarea'" :config="config" v-model="article.description"></froala>
                </td>
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
    <!-- Include JS file. -->
    <script type='text/javascript' src='https://cdn.jsdelivr.net/npm/froala-editor@2.9.3/js/froala_editor.min.js'></script>

    <script>

        new Vue({
            el: '#wrap',
            data() {
                return {
                    editor: null,
                    filter: {
                        group: "{{ Request::get('type') ?? 'notice' }}",
                        platform: "{{ Request::get('platform') }}",
                        language: "{{ Request::get('language') }}",
                    },
                    article: {
                        title: "{{ $article->title }}",
                        description: "{{ $article->content }}",
                    },
                    config: {
                        key: "{{ env('FROALA_KEY') }}",
                        charCounterCount: false,
                        heightMin: 300,
                        imageUploadToS3: JSON.parse('{!! FroalaHelper::hash() !!}'),
                        fileUploadToS3: JSON.parse('{!! FroalaHelper::hash() !!}'),
                        imageDefaultWidth: 500,
                        imageMaxSize: 10 * 1024 * 1024,
                        immediateVueModelUpdate: true,
                        events: {
                            'froalaEditor.initialized': function (e, editor) {
                                this.editor = editor;
                            }
                        }
                    },
                    error: null,
                };
            },
            created() {
            },
            methods: {
                selectFilter: function(platform, language) {
                    this.filter.platform = platform;
                    this.filter.language = language;
                },
                fetch() {
                },
                ok: function () {
                    if (this.filter.platform == '') {
                        alert('플랫폼을 선택해주세요.');

                        return;
                    }

                    if (this.filter.language == '') {
                        alert('언어를 선택해주세요.');

                        return;
                    }

                    if (this.article.title == '') {
                        alert('제목을 입력해주세요.');

                        return;
                    }

                    if (this.article.description == '') {
                        alert('내용을 입력해주세요.');

                        return;
                    }

                    let form = new FormData()
                    form.append('title', this.article.title);
                    form.append('description', this.article.description);

                    axios.post("{{ route('api.admin.support.update', [$article->id]) }}", form, {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                            'X-HTTP-Method-Override': 'PUT'
                        }
                    })
                        .then(function (response) {
                            window.location = document.referrer
                        })
                        .catch(function (response) {
                            // this.error = response;
                            // console.log('condition-revision-box error : ' + response);
                        });
                },
                cancel: function () {
                    window.location = document.referrer
                },
            }
        });

    </script>
@endsection