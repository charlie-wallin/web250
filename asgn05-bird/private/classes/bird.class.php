<?php

class Bird
{
    public const HABITATS = [
        'Backyards and thickets',
        'Deciduous forests',
        'Forest edges and gardens',
        'Forests',
        'Forests and neighborhoods',
        'Lawns and open woods',
        'Mature forests',
        'Mountain forests',
        'Woodland edges'
    ];

    public const FOOD_TYPES = [
        'Insects',
        'Insects and fruit',
        'Insects and seeds',
        'Nectar and insects',
        'Seeds and fruit',
        'Seeds and insects',
        'Small animals'
    ];

    protected const CONSERVATION_OPTIONS = [
        1 => 'Low concern',
        2 => 'Moderate concern',
        3 => 'Extreme concern',
        4 => 'Extinct'
    ];

    public static $count = 0;

    public $common_name;
    public $scientific_name;
    public $habitat;
    public $food;
    public $nest_placement;
    public $behavior;
    public $backyard_tips;

    protected $wingspan_cm;
    protected $weight_g;
    protected $conservation_id;

    public function __construct($args = [])
    {
        self::$count++;

        $this->common_name = $args['common_name'] ?? '';
        $this->scientific_name = $args['scientific_name'] ?? '';
        $this->habitat = $args['habitat'] ?? '';
        $this->food = $args['food'] ?? '';
        $this->nest_placement = $args['nest_placement'] ?? '';
        $this->behavior = $args['behavior'] ?? '';
        $this->backyard_tips = $args['backyard_tips'] ?? '';

        $this->set_wingspan_cm($args['wingspan_cm'] ?? 0);
        $this->set_weight_g($args['weight_g'] ?? 0);
        $this->conservation_id = (int) ($args['conservation_id'] ?? 1);
    }

    public function wingspan_cm()
    {
        return number_format($this->wingspan_cm, 1) . ' cm';
    }

    public function set_wingspan_cm($value)
    {
        $this->wingspan_cm = (float) $value;
    }

    public function wingspan_in()
    {
        $inches = $this->wingspan_cm * 0.393701;
        return number_format($inches, 1) . ' in';
    }

    public function set_wingspan_in($value)
    {
        $this->wingspan_cm = (float) $value / 0.393701;
    }

    public function weight_g()
    {
        return number_format($this->weight_g, 1) . ' g';
    }

    public function set_weight_g($value)
    {
        $this->weight_g = (float) $value;
    }

    public function weight_oz()
    {
        $ounces = $this->weight_g * 0.0352740;
        return number_format($ounces, 2) . ' oz';
    }

    public function conservation()
    {
        return self::CONSERVATION_OPTIONS[$this->conservation_id] ?? 'Unknown';
    }

    public function size_class()
    {
        // These cutoffs split this course data into useful teaching groups.
        // They are not scientific bird-size classifications.
        if ($this->wingspan_cm < 30) {
            return 'Small';
        }

        if ($this->wingspan_cm < 60) {
            return 'Medium';
        }

        return 'Large';
    }

    public function display_name()
    {
        // This method intentionally returns plain text. The view owns HTML
        // markup, so it can escape each value before adding <em> around the
        // scientific name. Mixing HTML into the model would make escaping
        // more error-prone.
        if ($this->scientific_name === '') {
            return $this->common_name;
        }

        return $this->common_name . ' (' . $this->scientific_name . ')';
    }

    public static function find_by_habitat($birds, $habitat)
    {
        $matches = array_filter(
            $birds,
            function ($bird) use ($habitat) {
                return $bird instanceof Bird && $bird->habitat === $habitat;
            }
        );

        return array_values($matches);
    }
}
