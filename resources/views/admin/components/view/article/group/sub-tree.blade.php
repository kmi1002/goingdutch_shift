@foreach($groups as $group)
    <tr>
        <td>0</td>
        <td style="text-align:left">{{ $group->title }}</td>
        <td>{{ $group->code }}</td>
        <td>{{ $group->category->title }}</td>
        <td>{{ $group->platform }}</td>
        <td>{{ $group->language }}</td>
        <td>{{ $group->created_at }}</td>
        <td>{{ $group->updated_at }}</td>
        <td class="btn__list">
            <button type="button" class="btn__item" @click="updateSupport({{ $group->id }})">수정</button>
            <button type="button" class="btn__item--red" @click="deleteSupport({{ $group->id }})">삭제</button>
        </td>
    </tr>
@endforeach