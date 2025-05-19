@extends('layouts.app')

@section('title', '体重管理')

@section('css')
<link rel="stylesheet" href="{{ asset('css/weight_logs.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
@endsection

@section('content')
<div class="header">
    <h1 class="logo">PiGLy</h1>
    <div class="header-action">
        <a href="{{ route('weight_logs.goal_setting') }}" class="custom-button">
            <i class="bi bi-gear"></i>目標体重設定
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="custom-button">
                <i class="bi bi-box-arrow-right"></i>ログアウト
            </button>
        </form>
    </div>
</div>

<div class="weight-tracker">
    <!-- 統計概要 -->
    <div class="stats-contents">
        <div class="stat-box">
            <div class="stat-label">目標体重</div>
            <h2 class="stat-value">{{ $targetWeight }}<span class="stat-unit">kg</span></h2>
        </div>
        <div class="separator"></div>
        <div class="stat-box">
            <div class="stat-label">目標まで</div>
            <h2 class="stat-value">{{ $weightDifference }}<span class="stat-unit">kg</span></h2>
        </div>
        <div class="separator"></div>
        <div class="stat-box">
            <div class="stat-label">最新体重</div>
            <h2 class="stat-value">{{ $latestWeight }}<span class="stat-unit">kg</span></h2>
        </div>
    </div>
    <div class="data-contents">
        <!-- 検索フィルター -->
        <div class="fillter-row">
            <form action="{{ route('weight_logs.search') }}" class="search-form">
                <div class="data-inputs">
                    <input type="date" name="start_date" class="form-control" value="{{ $startDate ?? '' }}">
                    <span class="range-separator">~</span>
                    <input type="date" name="end_date" class="form-control" value="{{ $endDate ?? '' }}">
                    <button type="submit" class="btn-search">検索</button>
                    <a href="{{ route('weight_logs.index') }}" class="btn-reset">リセット</a>
                </div>
                <button type="button" class="btn-add" id="openModalBtn">データ追加</button>
                @if (request()->has('start_date') || request()->has('end_date'))
                <div class="search-result-info">
                    <div class="reset-message">
                        {{ $startDate }} ~ {{ $endDate }} の検索結果 {{ $weightLogs->total() }}件
                    </div>
                </div>
                @endif
            </form>
        </div>

        <!-- データテーブル -->
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr class="table-title">
                        <th>日付</th>
                        <th>体重</th>
                        <th>食事摂取カロリー</th>
                        <th>運動時間</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($weightLogs as $log)
                    <tr class="data-row">
                        <td class="date-cell">{{ date('Y/m/d', strtotime($log->date)) }}</td>
                        <td class="date-cell">{{ $log->weight }}kg</td>
                        <td class="date-cell">{{ $log->calories }}cal</td>
                        <td class="date-cell">{{ $log->exercise_time }}</td>
                        <td>
                            <a href="{{ route('weight_logs.edit', $log->id) }}" class="edit-button">
                                <i class="bi bi-pencil"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <!-- ページネーション -->
    <div class="pagination">
        {{ $weightLogs->links() }}
    </div>
</div>

<!-- モーダルウィンドウ（登録機能画面） -->
<div id="addDataModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Weight Logを追加</h2>
        </div>
        <form method="post" action="{{ route('weight_logs.store') }}" id="addDataForm" novalidate>
            @csrf
            <div class="form-group">
                <label class="form-label" for="date">日付<span class="span">必須</span></label>
                <input type="date" id="date" name="date" class="form-input" value="{{ date('Y-m-d') }}" required>
                @error('date')
                <div class="validation-error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="weight">体重(kg)<span class="span">必須</span></label>
                <input type="text" id="weight" name="weight" class="form-input" step="0.1" required value="{{ old('weight') }}" placeholder="50.0">
                @error('weight')
                <div class="validation-error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="calories">摂取カロリー<span class="span">必須</span></label>
                <input type="text" id="calories" name="calories" class="form-input" value="{{ old('calories') }}" placeholder="1200">
                @error('calories')
                <div class="validation-error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="exercise_time">運動時間<span class="span">必須</span></label>
                <input type="time" id="exercise_time" name="exercise_time" class="form-input" value="{{ old('exercise_time') }}" placeholder="00:00">
                @error('exercise_time')
                <div class="validation-error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="exercise_content">運動内容</label>
                <textarea name="exercise_content" id="exercise_content" class="form-textarea" placeholder="運動内容を追加">{{ old('exercise_content') }}</textarea>
                @error('exercise_content')
                <div class="validation-error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-button">
                <button type="button" class="btn-cansel" id="closeModalBtn">戻る</button>
                <button type="submit" class="btn-register">登録</button>

            </div>
        </form>
    </div>
</div>
@if ($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('addDataModal').style.display = 'block';
    });
</script>
@endif
@endsection