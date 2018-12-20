<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Config;
use App\Http\Requests\UploadBannerRequest;
use App\Helpers\UploadImage;
use Illuminate\Support\Facades\Storage;

class ConfigController extends Controller
{
    protected $config;
    protected $banner;
    protected $info;
    protected $term;
    protected $policy;

    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->banner = $this->config->getBanner();
        $this->info = $this->config->getInfo();
        $this->term = $this->config->getTerm();
        $this->policy = $this->config->getPolicy();
    }

    public function index()
    {
        $data = [
            'banner' => $this->banner,
            'info' => $this->info,
            'term' => $this->term,
            'policy' => $this->policy
        ];
        return view('admin.config.index', $data);
    }

    public function updateBanner(UploadBannerRequest $rq)
    {
        $arr = $this->getArrayBanner();

        if ($rq->file('value')->isValid()) {
            $image = new UploadImage($rq->file('value'));
            $arr[] = $image->handleUploadAndResize(200);
            $this->saveBanner($arr);
            return back()->with('success', 'Upload files thành công!');
        } else {
            return back()->with('error', 'Upload files thất bại!');
        }
    }

    //xóa trên db và file
    public function deleteBanner($key)
    {
        $this->banner = $this->config->getBanner();
        $arr = $this->getArrayBanner();
        $result = $this->destroyBanner($arr, $key);
        $this->saveBanner($result);
        $this->deleteFileBanner($arr[$key]);
        return back();
    }

    public function updateInfo(Request $rq)
    {
        $this->info->value = $rq->info;
        $this->info->save();
        return back();
    }

    public function updateTerm(Request $rq)
    {
        $this->term->value = $rq->term;
        $this->term->save();
        return back()->with("success","Cập nhật điều khoản thành công");
    }

    public function updatePolicy(Request $rq)
    {
        $this->policy->value = $rq->policy;
        $this->policy->save();
        return back()->with("success","Cập nhật chính sách thành công");
    }

    protected function getArrayBanner()
    {
        return unserialize($this->banner->value);
    }

    //xóa phần tử trong mảng banner
    protected function destroyBanner($arr, $key)
    {
        unset($arr[$key]);
        return array_merge($arr);
    }

    //lưu mảng mới lên db
    protected function saveBanner($arr)
    {
        $this->banner->value = serialize($arr);
        $this->banner->save();
    }

    //xóa file ảnh banner
    protected function deleteFileBanner($banner)
    {
        Storage::delete(['upload/' . $banner, 'upload/resized-' . $banner]);
    }
}
