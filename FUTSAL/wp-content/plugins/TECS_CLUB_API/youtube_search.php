<?php

class youtube_search {
  // 구글api 주소
  private $api_base   = 'https://www.googleapis.com';
  // 유튜브 검색 주소
  private $api_search = '/youtube/v3/search';
  // 유튜브 비디어 정보 주소
  private $api_video  = '/youtube/v3/videos';
  // 유튜브 데이터 키
  private $api_key    = '';
  // 결과수
  private $data_count = 5;
  // 검색어
  private $q = '';
  // 유튜브 페이징용 토큰
  private $pagetoken = '';

  public function __construct($_key, $_q, $_count=5, $_pgtoken='') {
    $this->api_key = $_key;
    $this->q = $_q;
    $this->data_count = $_count;
    $this->pagetoken = $_pgtoken;
  }

  // curl로 데이터를 얻어온다
  private function curl_fetch($_u) {
    $ch = curl_init($_u);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $a = curl_exec($ch);
    curl_close($ch);
    return $a;
  }

  //DateInterval->format 시간과 유튜브 플레이어 시간이 꼭 1초씩 차이가 난다 ???. 보정하자.
  private function format_his($_tm) {
    $durt = new DateInterval($_tm);
    //return $durt->format('%H:%I:%S');
    $sec = $durt->h * 3600 + $durt->i * 60 + $durt->s;
    return gmdate('H:i:s',$sec-1);
  }

  // 비디오 정보 검색시 비디오 아이디를 콤마로 연결해서 한번에 질의한다
  private function set_qvid($_items) {
    $vid = '';
    foreach($_items as $k => $v) {
      $vid.= $v['id']['videoId'].',';
    }
    return substr($vid,0,-1);
  }

  // 유튜브의 경우 검색으로 얻은 동영상 목록에 플레이 시간이 안나온다
  // 플레이 시간(duration time)은 비디오 상세 정보를 얻어야 한다.
  // 비디오 상세정보는 비디오 아이디를 콤마로 연결해서 한번에 질의할 수 있다.
  // 유튜브 검색의 경우엔 1,2,3,4 와 같은 페이징은 불가하고(시작점을 직접 지정할 수가 없다)
  // 이전페이지, 다음페이지의 형식만 가능한 것 같다.
  public function get_data() {
    if(!$this->api_key) {
      return "유튜브 api키값이 없습니다.";
    }
    if(!$this->q) {
      return "검색어를 입력하세요.";
    }
    if(!$this->data_count) {
      return "목록수 값이 없습니다.";
    }

    // 유튜브 검색 참조 문서 https://developers.google.com/youtube/v3/docs/search
    $schparam = array(
      'key'        => $this->api_key,
      'q'          => $this->q,
      'maxResults' => $this->data_count,
      'pageToken'  => $this->pagetoken,
      'part'       => 'id,snippet',
      'type'       => 'video'
    );
    $u = $this->api_base.$this->api_search.'?'.http_build_query($schparam);
    $r = $this->curl_fetch($u);
    $data = json_decode($r,true);
    if(count($data['items']) <= 0) return $data;

    // 비디오 정보 참조 문서 https://developers.google.com/youtube/v3/docs/videos
    $vdoparam = array(
      'key'  => $this->api_key,
      'id'   => $this->set_qvid($data['items']),
      'part' => 'contentDetails'
    );
    $u = $this->api_base.$this->api_video.'?'.http_build_query($vdoparam);
    $r = $this->curl_fetch($u);
    $video = json_decode($r,true);

    // 검색 결과와 비디오 정보 합치기
    foreach($data['items'] as $dk => $dv) {
      foreach($video['items'] as $vk => $vv) {
        if($vv['id'] == $dv['id']['videoId']) {
          // youtube duration format은 ISO 8601 PT#M#S 형식 이다. 시분초로 변환한다.
          $playtime = $this->format_his($vv['contentDetails']['duration']);
          $vv['contentDetails']['playtime'] = $playtime;
          $data['items'][$dk]['details'] = $vv['contentDetails'];
          break;
        }
      }
    }

    return $data;
  }
}
    
?>

