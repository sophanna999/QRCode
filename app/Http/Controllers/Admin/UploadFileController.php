<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UploadFileController extends Controller
{
    public function index(Request $request){
    	$type = $request->file->extension();
    	$return['path'] = $request->file->storeAs('files',time().'-'.str_random(5).'.'.$type,'uploads');
    	$return['extension'] = $type;
    	switch ($return['extension']) {
    		case 'png':
				$return['link_preview'] = asset('uploads/'.$return['path']);
			break;
    		case 'jpg':
				$return['link_preview'] = asset('uploads/'.$return['path']);
			break;
    		case 'jpeg':
				$return['link_preview'] = asset('uploads/'.$return['path']);
			break;
    		case 'gif':
				$return['link_preview'] = asset('uploads/'.$return['path']);
			break;
    		case 'pdf':
				$return['link_preview'] = asset('images/pdf.png');
			break;
			case 'doc':
				$return['link_preview'] = asset('images/word.png');
			break;
			case 'docx':
				$return['link_preview'] = asset('images/word.png');
			break;
			case 'xls':
				$return['link_preview'] = asset('images/excel.png');
			break;
			case 'xlsx':
				$return['link_preview'] = asset('images/excel.png');
			break;
    		default:
    			$return['link_preview'] = asset('images/file.png');
			break;
    	}
    	return $return;
    }
}
