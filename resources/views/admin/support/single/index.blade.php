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
            @change-filter="selectFilter"
            @change-revision="selectRevision"
            @revision-ok="revisionOK">
    </admin-condition-revision-box>

    <div class="table-box support">
        <div class="support__content" v-html="article.content">
        </div>
    </div>
@endsection


@section('bottom_scripts')

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
                    article: ''
                };
            },
            created() {
            },
            methods: {
                selectFilter: function(platform, language) {
                    this.filter.platform = platform;
                    this.filter.language = language;
                },
                selectRevision: function(revision) {
                    this.filter.revision = revision;

                    if (this.filter.revision == '') {
                        return;
                    }

                    let app = this;
                    axios.get('/api/admin/support/' + this.filter.revision)
                    .then(function (response) {
                        app.article = response.data.data;
                    })
                    .catch(function (response) {
                        //console.log(response);
                    });
                },
                revisionOK: function () {
                    location.href = "/admin/support/single/create?type={{ $type }}&platform=" + this.filter.platform + "&language=" + this.filter.language + "&revision=" + this.filter.revision;
                },
            }
        });

    </script>
@endsection