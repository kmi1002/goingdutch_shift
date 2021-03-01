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

    <div class="table-box">
        <table class="popup-table">
            <colgroup>
                <col width="114px" />
            </colgroup>
            <tr>
                <th>플랫폼</th>
                <td>{{ $article->groups->platform }}</td>
            </tr>
            <tr>
                <th>언어</th>
                <td>{{ $article->groups->language }}</td>
            </tr>
            <tr>
                <th>제목</th>
                <td>{{ $article->title }}</td>
            </tr>
            <tr>
                <th>내용</th>
                <td>{{ $article->content }}</td>
            </tr>
        </table>
        <div class="table__addition">
            <div>
                <button type="button" class="btn-white" @click="listBack">목록</button>
            </div>
            <div>
                <button type="button" class="btn-white" @click="updateOriginal({{ $article->id }})">수정</button>
                <button type="button" class="btn-white" @click="deleteOriginal({{ $article->id }})">삭제</button>
            </div>
        </div>
    </div>
@endsection


@section('bottom_scripts')

    <script>

        new Vue({
            el: '#wrap',
            data() {
                return {
                    article: {
                        title: '',
                        description: ''
                    },
                    error: null,
                };
            },
            created() {
            },
            methods: {
                listBack() {
                    window.location = document.referrer
                },
                updateOriginal(id) {
                    location.href = "/admin/support/multiple/" + id + "/edit";
                },
                deleteOriginal(id) {
                    if (confirm('게시물을 삭제할까요?')) {
                        axios.delete("/api/admin/support/" + id)
                            .then(function (response) {
                                window.location = document.referrer
                            })
                            .catch(function (response) {
                                //console.log(response);
                            });
                    }
                }
            }
        });

    </script>
@endsection