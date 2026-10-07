<?php
class Instrument
{
    private string $name;
    private string $type;
    private int $stringCount;

    // GETTER: returns the value of a private property.
    // Private properties can't be accessed directly from outside
    // the class (e.g., $instrument->name would cause an error),
    // so a getter provides safe, read-only access to that value.
    public function getName(): string
    {
        // $this refers to the CURRENT object the method is being
        // called on. It lets the method reach the object's own
        // properties instead of some unrelated variable.
        return $this->name;
    }

    // SETTER: assigns a value to a private property.
    // Instead of letting outside code change the property directly,
    // the setter controls how and when it gets updated.
    public function setName(string $name): void
    {
        // $this->name is the object's property.
        // $name (no "$this->") is just the parameter passed in.
        // This line copies the parameter's value into the property.
        $this->name = $name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        // Simple validation without exceptions: if the value isn't
        // recognized, fall back to a safe default instead of crashing.
        $type = strtolower($type);
        if ($type !== "string" && $type !== "wind" && $type !== "percussion") {
            $type = "unknown";
        }
        $this->type = $type;
    }

    public function getStringCount(): int
    {
        return $this->stringCount;
    }

    public function setStringCount(int $stringCount): void
    {
        // Instead of throwing an error for a bad value, just correct it.
        if ($stringCount < 0) {
            $stringCount = 0;
        }
        $this->stringCount = $stringCount;
    }
}
// create a new instance of the Instrument class
$instrument = new Instrument();
$instrument->setName("Guitar");
$instrument->setType("string");
$instrument->setStringCount(6);

echo $instrument->getName() . " is a " . $instrument->getType() .
    " instrument with " . $instrument->getStringCount() . " strings.";
