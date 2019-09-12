<?php
class ModelExtensionModuleDocument extends Model {

	public function install() {

        $this->createDatabase();

        $templates = glob(DIR_CATALOG.'view/theme/*');
        foreach($templates as $template) {
            $info_data = array(
                'file' => $template . '/template/product/product.twig',
                'mihez' => '{{ tab_description }}</a></li>',
                'mit' => '{% if documents %}<li><a href="#tab-document" data-toggle="tab">{{ tab_document }}</a></li>{% endif %}'
            );
            $this->rogzit($info_data);

            $info_data = array(
                'file' => $template . '/template/product/product.twig',
                'mihez' => '{{ description }}</div>',
                'mit' => '{% if documents %}<div class="tab-pane" id="tab-document">{% for document in documents %}<a href="{{ document.href }}" target="_blank" data-toggle="tooltip" title="{{ button_download }}" class="btn btn-primary"><i class="fa fa-cloud-download"></i> {{ document.name }} ({{ document.size}})</a><br>{% endfor %}</div>{% endif %}'
            );
            $this->rogzit($info_data);

            $info_data = array(
                'file' => $template . '/template/product/category.twig',
                'mihez' => '<div class="product-thumb">',
                'mit' => '{{ product.icons }}'
            );
            $this->rogzit($info_data);
        }

        $templates = glob(DIR_MODIFICATION.'catalog/view/theme/*');
        foreach($templates as $template) {
            $info_data = array(
                'file' => $template . '/template/product/product.twig',
                'mihez' => '{{ tab_description }}</a></li>',
                'mit' => '{% if documents %}<li><a href="#tab-document" data-toggle="tab">{{ tab_document }}</a></li>{% endif %}'
            );
            $this->rogzit($info_data);

            $info_data = array(
                'file' => $template . '/template/product/product.twig',
                'mihez' => '{{ description }}</div>',
                'mit' => '{% if documents %}<div class="tab-pane" id="tab-document">{% for document in documents %}<a href="{{ document.href }}" target="_blank" data-toggle="tooltip" title="{{ button_download }}" class="btn btn-primary"><i class="fa fa-cloud-download"></i> {{ document.name }} ({{ document.size}})</a><br>{% endfor %}</div>{% endif %}'
            );
            $this->rogzit($info_data);

            $info_data = array(
                'file' => $template . '/template/product/category.twig',
                'mihez' => '<div class="product-thumb">',
                'mit' => '{{ product.icons }}'
            );
            $this->rogzit($info_data);
        }

        $this->deleteTwigCache();
	}

    private function  rogzit($data) {
        $siker = false;

        if (file_exists($data['file'])) {
            $contents = file_get_contents($data['file']);

            if (strpos($contents,$data['mit']) === false) {

                $contents = str_replace($data['mihez'],$data['mihez'].$data['mit'],$contents);
                $siker = file_put_contents($data['file'], $contents);
            }
        }
        return $siker;
    }

    private function deleteTwigCache() {
        $directories = glob(DIR_CACHE . '*', GLOB_ONLYDIR);

        if ($directories) {
            foreach ($directories as $directory) {
                $files = glob($directory . '/*');

                foreach ($files as $file) {
                    if (is_file($file)) {
                        unlink($file);
                    }
                }

                if (is_dir($directory)) {
                    rmdir($directory);
                }
            }
        }
    }

    private function createDatabase() {

        $this->db->query("CREATE TABLE if not exists " . DB_PREFIX . "product_document (
                            product_document_id int(11) AUTO_INCREMENT,
	                        product_id          int(11),
	                        document            varchar(255),
	                        sort_order           int(11),
             PRIMARY KEY (product_document_id) )   engine=MyISAM default charset=UTF8");

        $sql = "CREATE TABLE if not exists " . DB_PREFIX . "product_document_name (
                            product_document_id int(11),
	                        language_id          int(11),
	                        product_id          int(11),
	                        document_name        varchar(255),
             PRIMARY KEY (product_document_id,language_id) )   engine=MyISAM default charset=UTF8";


        $this->db->query($sql);


    }
}