public function permissions() {
    return $this->belongsToMany(Permission::class);
}