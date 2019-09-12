<?php
class ControllerExtensionModuleDocument extends Controller {

	private $error = array();

	public function index() {

		$this->load->language('extension/module/document');

		$this->load->model('setting/setting');

		$this->document->setTitle($this->language->get('heading_title'));

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('module_document', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/document', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['action'] = $this->url->link('extension/module/document', 'user_token=' . $this->session->data['user_token'], true);

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);
		$data['document_status_link'] = str_replace('&amp;', '&',$this->url->link('extension/document_status', 'user_token=' . $this->session->data['user_token'] , true));

		$data['user_token'] = $this->session->data['user_token'];



		if (isset($this->request->post['module_document_status'])) {
			$data['module_document_status'] = $this->request->post['module_document_status'];
		} else {
			$data['module_document_status'] = $this->config->get('module_document_status');
		}

        if (isset($this->request->post['module_document_image'])) {
            $data['module_document_image'] = $this->request->post['module_document_image'];
        } else {
            $data['module_document_image'] = $this->config->get('module_document_image');
        }

        $this->load->model('tool/image');

        if (isset($this->request->post['module_document_image']) && is_file(DIR_IMAGE . $this->request->post['module_document_image'])) {
            $data['thumb'] = $this->model_tool_image->resize($this->request->post['module_document_image'], 50, 50);
        } elseif ($data['module_document_image'] && is_file(DIR_IMAGE . $data['module_document_image'])) {
            $data['thumb'] = $this->model_tool_image->resize($data['module_document_image'], 50, 50);
        } else {
            $data['thumb'] = $this->model_tool_image->resize('no_image.png', 50, 50);
        }

        if (isset($this->request->post['module_document_image_width'])) {
            $data['module_document_image_width'] = $this->request->post['module_document_image_width'];
        } else {
            $data['module_document_image_width'] = $this->config->get('module_document_image_width');
        }
        if (isset($this->request->post['module_document_image_height'])) {
            $data['module_document_image_height'] = $this->request->post['module_document_image_height'];
        } else {
            $data['module_document_image_height'] = $this->config->get('module_document_image_height');
        }

        if (isset($this->request->post['module_document_style'])) {
            $data['module_document_style'] = $this->request->post['module_document_style'];
        } else {
            $data['module_document_style'] = $this->config->get('module_document_style');
        }

        if (is_null($data['module_document_style'])) {
            $data['module_document_style'] = 'position: absolute; right: 0; top: 0;';
        }


        $data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/document', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/document')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

    public function install() {

        $this->load->model('user/user_group');

        $this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/module/document');
        $this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/module/document');

        $this->load->model('extension/module/document');
        $this->model_extension_module_document->install();
    }

}
