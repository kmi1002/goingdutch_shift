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
    $type = Request::get('type') ?? 'introduce';

    $title = "";
    switch ($type) {
        case 'terms': $title = "이용약관"; break;
        case 'privacy': $title = "개인정보취금방침"; break;
        default: $title = "소개"; break;
    }
    ?>

    <admin-title-box
            :show-calendar="false">
        <template slot="header">
            <span class="title-box__title">{{ $title }}</span>
        </template>
    </admin-title-box>

    <admin-condition-revision-box
            api-url="{{ route('api.admin.support.revision', ['group' => $type]) }}"
            group-code="{{ $type }}"
            :platform="filter.platform"
            :language="filter.language"
            :create-mode="true"
            @change-filter="selectFilter"
            @select-revision="selectRevision"
            @revision-ok="revisionOK"
            @revision-cancel="revisionCancel">
    </admin-condition-revision-box>

    <div class="table-box">
        <table class="popup-table">
            <colgroup>
                <col width="114px" />
            </colgroup>
            <tr>
                <th>내용</th>
                <td>
                    <froala :tag="'textarea'" :config="config" v-model="article.description"></froala>
                </td>
            </tr>
        </table>
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
                    filter: {
                        platform: "{{ Request::get('platform') }}",
                        language: "{{ Request::get('language') }}",
                        revision: "{{ Request::get('revision') }}"
                    },
                    revisions:[],
                    article: {
                        group: "{{ $type }}",
                        title: '',
                        description: ''
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
                            }
                        }
                    },
                    error: null,
                };
            },
            created() {
                this.fetch();
            },
            methods: {
                selectFilter: function(platform, language) {
                    this.filter.platform = platform;
                    this.filter.language = language;
                },
                selectRevision: function(revision) {
                    this.filter.revision = revision;
                },
                fetch() {
                    if (this.filter.revision == '' || this.filter.revision == 0) {
                        return;
                    }

                    let app = this;
                    axios.get('/api/admin/support/' + this.filter.revision)
                        .then(function (response) {
                            app.article.description = response.data.data.content;
                        })
                        .catch(function (response) {
                            //console.log(response);
                        });
                },
                revisionOK: function () {
                    let app = this;

                    if (this.filter.platform == '') {
                        alert('플랫폼을 선택해주세요.');

                        return;
                    }

                    if (this.filter.language == '') {
                        alert('언어를 선택해주세요.');

                        return;
                    }

                    if (this.article.description == '') {
                        alert('내용을 입력해주세요.');

                        return;
                    }

                    let form = new FormData()
                    form.append('platform', this.filter.platform);
                    form.append('language', this.filter.language);
                    form.append('revision', this.filter.revision);
                    form.append('group', this.article.group);
                    form.append('title', this.article.title);
                    form.append('description', this.article.description);

                    axios.post("{{ route('api.admin.support.store') }}", form, {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        })
                        .then(function (response) {
                            window.location = document.referrer + "&platform=" + app.filter.platform + "&language=" + app.filter.language;
                        })
                        .catch(function (response) {
                            // this.error = response;
                            console.log('condition-revision-box error : ' + response);
                        });
                },
                revisionCancel: function () {
                    window.location = document.referrer
                },
            }
        });

    </script>
@endsection