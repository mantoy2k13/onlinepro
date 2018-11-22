@extends('layouts.user.application', ['noFrame' => false, 'bodyClasses' => ''])

@section('metadata')
@stop

@section('styles')
    @parent
@stop

@section('title')
    プライバシー・ポリシー | SEKAIHE - ワンコインで気軽に相談。海外生活の悩みはセカイへ
@stop

@section('scripts')
    @parent
@stop

@section('content')

@section('breadcrumbs', Breadcrumbs::render('privacy'))
<div class="grayarea">
    <h2 class="title-m">プライバシー・ポリシー</h2>
</div>
<section>
    <div class="content">
        <p>当社は、お客様の個人情報を最重要資産の一つとして認識すると共に、以下の方針に基づき個人情報の適切な取り扱いと保護に努めることを宣言いたします。</p>
        <dl class="rule">
            <dt>個人情報保護に関する法令および規律の遵守</dt>
            <dd>個人情報の保護に関する法令およびその他の規範を遵守し、個人情報を適正に取り扱います。 </dd>
            <dt>個人情報の定義</dt>
            <dd>個人情報とは、お客様が当社のサービスをご利用するにあたりご登録いただくご氏名、郵便番号、住所、電話番号、メールアドレス等の情報により 個人を識別できる情報をいいます。 ただし、レッスン中にメールアドレスや電話番号を講師に教えるなど、お客様が当社の講師に直接お伝えしてしまった情報については、 ここでいう個人情報とはみなさないものとします。</dd>
            <dt>個人情報の取得</dt>
            <dd>当社が提供するサービスをご利用いただく際に、ユーザーに個人情報をご提供いただきます。<br>個人情報の取得に際しては、利用目的を明確化するよう努力し、適法かつ公正な手段により行います。</dd>
            <dt>個人情報の利用</dt>
            <dd>取得した個人情報は、取得の際に示した利用目的もしくは、それと合理的な関連性のある範囲内で、業務の遂行上必要な限りにおいて利用します。 当社は収集した個人情報を、以下の場合のみに利用します。
                <ul>
                    <li>1.本サービスに係わる情報をお知らせするため</li>
                    <li>2.トラブル発生時対応のため</li>
                    <li>3.サービス利用料金の精算関係業務のため</li>
                    <li>4.本人確認のため</li>
                    <li>5.提供するサービスに必要な場合（弊社の販売促進、キャンペーンも含む）</li>
                    <li>6.また、ユーザー当社利用規約に同意していることを前提として、当社からユーザーへ情報配信をします。</li>
                </ul>
                これらは、当社が提供する様々なサービス（ニュースレター、キャンペーン情報、アンケート等）に関する重要な情報をユーザーに連絡するためです。
            </dd>
            <dt>個人情報の第三者提供</dt>
            <dd>法令に定める場合を除き、個人情報を事前に本人の同意を得ることなく第三者に提供することはありません。</dd>
            <dt>個人情報の管理</dt>
            <dd>個人情報の正確性および最新性を保つよう努力し、適正な取り扱いと管理を実施するための体制を構築するとともに個人情報の紛失、改ざん、漏洩などを防止するため、必要かつ適正な情報セキュリティー対策を実施します。 当社がお預かりする個人情報は保護すべき重要な情報です。 当社はお客様の個人情報を 保護・管理するにあたり合理的かつ必要な予防措置を講じます。 また、お客様は、プライベートで使うスカイプ名を当社に登録しないようにするなど、 自身の情報を保護・管理するにあたり合理的かつ必要な予防措置を講じます。 ただし、スカイプ名は、スカイプのソフトウェアなどで検索可能な一般公開情報であり、 レッスン提供を目的として講師に対して公開する情報ですので、当社が合理的かつ必要な予防措置を講じて保護・管理する対象の個人情報には該当しません。 お客様は、プライベートで使うものとは別のスカイプ名を当社に登録するなど、 自身の個人情報を保護・管理するにあたり合理的かつ必要な予防措置を講じます。</dd>
            <dt>個人情報の開示・訂正・利用停止・消去</dt>
            <dd>個人情報について、開示・訂正・利用停止・消去などの要求がある場合には、本人からの要求であることが確認できた場合に限り、法令に従って対応します。</dd>
            <dt>教育訓練</dt>
            <dd>当社は、個人情報保護に対する意識の向上を目指すとともに、個人情報保護に関するコンプライアンス・プログラムについての教育／訓練を行ないます。</dd>
            <dt>講師との接触</dt>
            <dd>個人が弊社のサービスにおける講師とオンライン・オフライン問わず接触することを禁じます。 講師との個人的な接触が原因となって、個人情報が流出した場合は、弊社は一切の責任を負いません。</dd>
        </dl>
    </div>
</section>
@stop