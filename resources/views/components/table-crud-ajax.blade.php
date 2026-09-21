<div class="pt-4 font-size-12">
    <table class="table table-bordered dt-responsive table-striped w-100" id="datatable-crud-ajax">
        <thead>
            <tr>
                @foreach($tableColsNames as $tableColName)
                @if($tableColName == 'Ações')
                <th class="bg-dark-subtle text-dark" style="max-width: 50px;">{{ mb_strtoupper('Ações') }}</th>
                @elseif($tableColName == '#')
                <th class="bg-dark-subtle text-dark text-center" nowrap>{{mb_strtoupper($tableColName)}}</th>
                @else
                <th class="bg-dark-subtle text-dark text-start" nowrap>{{mb_strtoupper($tableColName)}}</th>
                @endif
                @endforeach
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
