@extends('layouts.user.application', ['noFrame' => false, 'bodyClasses' => ''])

@section('metadata')
@stop

@section('styles')
    @parent
@stop

@section('title')
    初めての方へ | SEKAIE - ワンコインで気軽に相談。海外生活の悩みはセカイへ
@stop

@section('scripts')
    @parent
@stop

@section('content')

@section('breadcrumbs', Breadcrumbs::render('beginner'))
    <div class="grayarea">
        <h2 class="title-m">初めての方へ</h2>
    </div>
    <section id="beginner-sekaihe">
        <div class="content">
            <h3 class="title-l fontcol-p arrow-p">SEKAIEとは</h3>
            <div class="about">
                <dl>
                    <dt><img src="{!! \URLHelper::asset('img/about-title.png', 'user') !!}" alt="SEKAIEとは、手軽にワンコインで1回500円でアドバイザーに相談出来る！"></dt>
                    <dd>SEKAIEは海外生活の悩みについて<strong class="em fontcol-g">オンラインでアドバイザーに直接相談できる</strong>サービスです。<br>パソコンはもちろんスマホやタブレットからでも相談できるので気軽にお使いいただけます。
                        <br>相談は<strong class="em fontcol-g">1回たったの500円</strong>。<br>低価格ながら、それぞれのアドバイザーがあなたの悩みに的確にお答えします。</dd>
                </dl>
            </div>
        </div>
    </section>
    <section>
        <div class="wrap">
            <h4 class="title-s cent under-pink">SEKAIEの特徴</h4>
            <ul class="block-point">
                <li>
                    <div><img src="{!! \URLHelper::asset('img/about-photo01.jpg', 'user') !!}" alt="相談は1回500円（定額）"><p><span>Point</span><strong>01</strong></p></div>
                    <dl>
                        <dt class="fontcol-p em heightLine-group1">相談は1回500円（定額）</dt>
                        <dd class="heightLine-group2">クレジットカードでも決済可能。まとめ買いでお得にご利用いただけます。</dd>
                    </dl>
                    <p><a href="#beginner-sekaihe" class="btn-gs arrow-gs">料金を見る</a></p>
                </li>
                <li>
                    <div><img src="{!! \URLHelper::asset('img/about-photo02.jpg', 'user') !!}" alt="厳選されたアドバイザー陣"><p><span>Point</span><strong>02</strong></p></div>
                    <dl>
                        <dt class="fontcol-p em heightLine-group1">厳選されたアドバイザー陣</dt>
                        <dd class="heightLine-group2">経験豊富なアドバイザーが相談にのります。</dd>
                    </dl>
                    <p><a href="{{ action('User\IndexController@index') }}#categories-area" class="btn-gs arrow-gs">アドバイザーを検索</a></p>
                </li>
                <li>
                    <div><img src="{!! \URLHelper::asset('img/about-photo03.jpg', 'user') !!}" alt="Skypeで簡単に相談"><p><span>Point</span><strong>03</strong></p></div>
                    <dl>
                        <dt class="fontcol-p em heightLine-group1">Skypeで簡単に相談</dt>
                        <dd class="heightLine-group2">パソコンだけでなくスマホでもご利用いただけます。</dd>
                    </dl>
                    <p><a href="https://www.skype.com/ja/features/" target="_blank" class="btn-gs arrow-gs">Skypeの使い方</a></p>
                </li>
                <li>
                    <div><img src="{!! \URLHelper::asset('img/about-photo04.jpg', 'user') !!}" alt="相談後内容をまとめたノートが届く"><p><span>Point</span><strong>04</strong></p></div>
                    <dl>
                        <dt class="fontcol-p em heightLine-group1">相談後内容をまとめた<br>ノートが届く</dt>
                        <dd class="heightLine-group2">アドバイザーの提案を繰り返して確認いただけます。</dd>
                    </dl>
                    @if( !empty($authUser) )
                        <p><a href="{{action('User\BookingController@getBookingHistories')}}" class="btn-gs arrow-gs">詳しく見る</a></p>
                    @else
                        <p><a href="#" onclick="openLoginPopup()" class="btn-gs arrow-gs">詳しく見る</a></p>
                    @endif
                </li>
            </ul>
        </div>
    </section>
    <section>
        <div class="content">
            <dl class="step outl-p">
                <dt class="step-title"><img src="{!! \URLHelper::asset('img/3step.png', 'user') !!}" alt="3step"></dt>
                <dd>
                    <ul class="flow">
                        <li>
                            <p><img src="{!! \URLHelper::asset('img/flow-regist.png', 'user') !!}" alt="regist"></p>
                            <dl>
                                <dt>01</dt>
                                <dd class="flow-title">無料会員登録</dd>
                            </dl>
                        </li>
                        <li class="flow-arrow"><img src="{!! \URLHelper::asset('img/arrow-pink-l.png', 'user') !!}" alt="arrow"></li>
                        <li>
                            <p><img src="{!! \URLHelper::asset('img/flow-reserve.png', 'user') !!}" alt="reserve"></p>
                            <dl>
                                <dt>02</dt>
                                <dd class="flow-title">アドバイザーを予約</dd>
                            </dl>
                        </li>
                        <li class="flow-arrow"><img src="{!! \URLHelper::asset('img/arrow-pink-l.png', 'user') !!}" alt="arrow"></li>
                        <li>
                            <p><img src="{!! \URLHelper::asset('img/flow-consult.png', 'user') !!}" alt="consult"></p>
                            <dl>
                                <dt>03</dt>
                                <dd class="flow-title">相談開始</dd>
                            </dl>
                        </li>
                    </ul>
                    <p class="cent">※レッスンにはSkypeが必要です。Skypeのインストール方法や操作方法は<a href="../guide/index.html">コチラ</a></p>
                </dd>
            </dl>
        </div>
    </section>
@stop
