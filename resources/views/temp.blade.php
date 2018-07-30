@extends('layouts.frontLayout.front_desgin')
@section('content')

    <div ng-app="checksys" style="margin-top: 200px">

        <div ng-controller="checkboxCtrl">

            <table>
                <thead>
                    <tr>
                        <th>Names</th>
                        <th><input type="checkbox" name="" ng-model="selectAll" ng-click="checkAll()">Select/Deselect All</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="catg in catgs ">
                        <td><%catg.name%></td>
                        <td><input type="checkbox" name="" data-ng-model="selected" ng-checked="exist(catg)" ng-click="toggleSelection(catg)"></td>
                    </tr>
                </tbody>
            </table>
            <h3>Selected Cats</h3>
            @foreach($booksall as $book)
                <div class="selectedcontent">
                    <div ng-repeat="selectedName in selected" ng-if="selectedName.id==={{$book->category_id}}">{{$book->book_title}}</div>
                    <div ng-if="selected.length===0">{{$book->book_title}}</div>
                </div>
            @endforeach
        </div>
    </div>



@endsection
