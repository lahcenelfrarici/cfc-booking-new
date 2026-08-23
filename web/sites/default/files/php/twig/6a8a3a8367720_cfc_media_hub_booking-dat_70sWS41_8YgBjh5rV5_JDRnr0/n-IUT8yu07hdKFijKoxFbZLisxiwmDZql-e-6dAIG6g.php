<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Sandbox\SecurityNotAllowedTestError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* cfc_media_hub:booking-datetime-picker */
class __TwigTemplate_803fccac7b5f220486ce344a1cc10f6b extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->extensions[SandboxExtension::class];
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 1
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\TwigExtension']->attachLibrary("core/components.cfc_media_hub--booking-datetime-picker"));
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\ComponentsTwigExtension']->addAdditionalContext($context, "cfc_media_hub:booking-datetime-picker"));
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\ComponentsTwigExtension']->validateProps($context, "cfc_media_hub:booking-datetime-picker"));
        yield "<div
  data-matrix=\x27";
        // line 2
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(($context["matrix"] ?? null));
        yield "\x27
  data-durations=\x27";
        // line 3
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(($context["durations_json"] ?? null));
        yield "\x27
  data-duration-hours=\x27";
        // line 4
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(($context["duration_hours_json"] ?? null));
        yield "\x27
  x-data=\"{
    matrix: {},
    durations: [],
    durationHours: {},
    selectedDuration: \x27";
        // line 9
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["default_duration"] ?? null), "html", null, true);
        yield "\x27,
    selectedDate: \x27\x27,
    selectedTime: \x27\x27,
    dayAvailable(iso) {
      const day = this.matrix[iso];
      if (!day) return false;
      return Object.keys(day).some((slot) => day[slot][this.selectedDuration]);
    },
    slotAvailable(slot) {
      // Deliberately not keyed to selectedDuration: picking a duration
      // shouldn\x27t grey out times that were already showing as pickable —
      // a slot stays enabled as long as it works for at least one of the
      // space\x27s durations. The exact duration+time combination is still
      // re-checked for real on submit (validateForm() / AvailabilityChecker),
      // so nothing invalid can actually get booked.
      if (!this.selectedDate) return false;
      const day = this.matrix[this.selectedDate];
      return !!(day && day[slot] && Object.values(day[slot]).some((free) => free));
    },
    durationAvailable(d) {
      // Unlike slotAvailable(), this IS keyed to the selected time — some
      // durations only make sense for specific slots (e.g. Full day only
      // starting at 09:00), so the choices shown must match the exact
      // slot just picked, not just \x27works for some slot\x27.
      if (!this.selectedDate || !this.selectedTime) return false;
      const day = this.matrix[this.selectedDate];
      return !!(day && day[this.selectedTime] && day[this.selectedTime][d]);
    },
    endTime(start, duration) {
      // Full day is meant to read as the whole business day (09:00-18:00)
      // even though it\x27s tracked/billed as 8h — always show closing time
      // rather than the literal start+8h arithmetic (which would say 17:00).
      if (duration === \x27Full day (8h)\x27) return \x2718:00\x27;
      const hours = this.durationHours[duration];
      if (!start || !hours) return \x27\x27;
      const [h, m] = start.split(\x27:\x27).map(Number);
      const total = h * 60 + m + hours * 60;
      const eh = Math.floor(total / 60) % 24;
      const em = total % 60;
      return String(eh).padStart(2, \x270\x27) + \x27:\x27 + String(em).padStart(2, \x270\x27);
    },
    pickDate(iso) {
      if (!this.dayAvailable(iso)) return;
      this.selectedDate = iso;
      document.getElementById(\x27";
        // line 53
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["date_field_id"] ?? null), "html", null, true);
        yield "\x27).value = iso;
    },
    pickTime(slot) {
      if (!this.slotAvailable(slot)) return;
      this.selectedTime = slot;
      document.getElementById(\x27";
        // line 58
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["time_field_id"] ?? null), "html", null, true);
        yield "\x27).value = slot;
      if (!this.durationAvailable(this.selectedDuration)) {
        const fallback = this.durations.find((d) => this.durationAvailable(d));
        if (fallback) {
          this.selectedDuration = fallback;
          document.getElementById(\x27";
        // line 63
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["duration_field_id"] ?? null), "html", null, true);
        yield "\x27).value = fallback;
        }
      }
    },
    pickDuration(d) {
      if (!this.durationAvailable(d)) return;
      this.selectedDuration = d;
      document.getElementById(\x27";
        // line 70
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["duration_field_id"] ?? null), "html", null, true);
        yield "\x27).value = d;
    },
  }\"
  x-init=\"matrix = JSON.parse(\$el.dataset.matrix); durations = JSON.parse(\$el.dataset.durations); durationHours = JSON.parse(\$el.dataset.durationHours);\"
>
  ";
        // line 75
        if ( !(($tmp = ($context["has_space"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 76
            yield "    <p class=\"text-neutral-500 text-[14px] bg-neutral-50 border border-neutral-100 rounded-2xl px-5 py-4\">
      Select a space above to see available dates.
    </p>
  ";
        } else {
            // line 80
            yield "    <div class=\"text-[12px] uppercase tracking-wide text-neutral-500 mb-4 font-semibold\">Choose a date</div>
    <div class=\"grid grid-cols-7 gap-2.5\">
      ";
            // line 82
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["days"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["d"]) {
                // line 83
                yield "        <button
          type=\"button\"
          x-on:click=\"pickDate(\x27";
                // line 85
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["d"], "iso", [], "any", false, false, true, 85), "html", null, true);
                yield "\x27)\"
          x-bind:disabled=\"!dayAvailable(\x27";
                // line 86
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["d"], "iso", [], "any", false, false, true, 86), "html", null, true);
                yield "\x27)\"
          x-bind:class=\"{
            \x27opacity-30 cursor-not-allowed border-neutral-100 bg-neutral-50\x27: !dayAvailable(\x27";
                // line 88
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["d"], "iso", [], "any", false, false, true, 88), "html", null, true);
                yield "\x27),
            \x27bg-[#9F5434] border-[#9F5434] text-white shadow-[0_8px_20px_-8px_rgba(159,84,52,0.4)]\x27: selectedDate === \x27";
                // line 89
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["d"], "iso", [], "any", false, false, true, 89), "html", null, true);
                yield "\x27,
            \x27border-neutral-200 bg-white hover:border-neutral-300\x27: dayAvailable(\x27";
                // line 90
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["d"], "iso", [], "any", false, false, true, 90), "html", null, true);
                yield "\x27) && selectedDate !== \x27";
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["d"], "iso", [], "any", false, false, true, 90), "html", null, true);
                yield "\x27,
          }\"
          class=\"rounded-2xl p-3 text-center transition-all border\"
        >
          <div class=\"text-[11px] mb-1.5 font-medium\" x-bind:class=\"selectedDate === \x27";
                // line 94
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["d"], "iso", [], "any", false, false, true, 94), "html", null, true);
                yield "\x27 ? \x27text-white/70\x27 : \x27text-neutral-400\x27\">";
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["d"], "weekday", [], "any", false, false, true, 94), "html", null, true);
                yield "</div>
          <div class=\"text-[16px] font-bold\" x-bind:class=\"selectedDate === \x27";
                // line 95
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["d"], "iso", [], "any", false, false, true, 95), "html", null, true);
                yield "\x27 ? \x27text-white\x27 : \x27text-neutral-900\x27\">";
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["d"], "day", [], "any", false, false, true, 95), "html", null, true);
                yield "</div>
          <div class=\"text-[11px] mt-0.5\" x-bind:class=\"selectedDate === \x27";
                // line 96
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["d"], "iso", [], "any", false, false, true, 96), "html", null, true);
                yield "\x27 ? \x27text-white/60\x27 : \x27text-neutral-400\x27\">";
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["d"], "month", [], "any", false, false, true, 96), "html", null, true);
                yield "</div>
          <div
            class=\"w-1.5 h-1.5 rounded-full mx-auto mt-2\"
            x-show=\"dayAvailable(\x27";
                // line 99
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["d"], "iso", [], "any", false, false, true, 99), "html", null, true);
                yield "\x27)\"
            x-bind:class=\"selectedDate === \x27";
                // line 100
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["d"], "iso", [], "any", false, false, true, 100), "html", null, true);
                yield "\x27 ? \x27bg-white/60\x27 : \x27bg-emerald-400\x27\"
          ></div>
        </button>
      ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['d'], $context['_parent']);
            $context = array_intersect_key($context, $_parent);
            $context += $_parent;
            // line 104
            yield "    </div>

    <div class=\"mt-6 flex items-center gap-5 text-[12px] text-neutral-400\">
      <span class=\"flex items-center gap-1.5\"><span class=\"w-2 h-2 rounded-full bg-emerald-400 inline-block\"></span> Available</span>
      <span class=\"flex items-center gap-1.5\"><span class=\"w-2 h-2 rounded-full bg-neutral-200 inline-block\"></span> Unavailable</span>
    </div>

    <div x-show=\"selectedDate\" x-cloak class=\"mt-8\">
      <div class=\"text-[12px] uppercase tracking-wide text-neutral-500 mb-4 font-semibold\">Available slots</div>
      <div class=\"grid grid-cols-5 gap-3\">
        ";
            // line 114
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["time_slots"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["slot"]) {
                // line 115
                yield "          <button
            type=\"button\"
            x-on:click=\"pickTime(\x27";
                // line 117
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $context["slot"], "html", null, true);
                yield "\x27)\"
            x-bind:disabled=\"!slotAvailable(\x27";
                // line 118
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $context["slot"], "html", null, true);
                yield "\x27)\"
            x-bind:class=\"{
              \x27opacity-30 cursor-not-allowed bg-neutral-50 border-neutral-100 text-neutral-400\x27: !slotAvailable(\x27";
                // line 120
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $context["slot"], "html", null, true);
                yield "\x27),
              \x27bg-[#9F5434] border-[#9F5434] text-white shadow-[0_8px_20px_-8px_rgba(159,84,52,0.35)] font-semibold\x27: selectedTime === \x27";
                // line 121
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $context["slot"], "html", null, true);
                yield "\x27,
              \x27bg-white border-neutral-200 text-neutral-900 hover:border-[#9F5434]/40 hover:bg-[#9F5434]/5\x27: slotAvailable(\x27";
                // line 122
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $context["slot"], "html", null, true);
                yield "\x27) && selectedTime !== \x27";
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $context["slot"], "html", null, true);
                yield "\x27,
            }\"
            class=\"py-3 rounded-xl border text-[14px] transition-all\"
          >
            ";
                // line 126
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $context["slot"], "html", null, true);
                yield "
          </button>
        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['slot'], $context['_parent']);
            $context = array_intersect_key($context, $_parent);
            $context += $_parent;
            // line 129
            yield "        ";
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["phantom_slots"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["slot"]) {
                // line 130
                yield "          <div
            class=\"py-3 rounded-xl border text-[14px] text-center select-none transition-all bg-white border-neutral-200 text-neutral-900 hover:border-[#9F5434]/40 hover:bg-[#9F5434]/5\"
            aria-disabled=\"true\"
          >
            ";
                // line 134
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $context["slot"], "html", null, true);
                yield "
          </div>
        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['slot'], $context['_parent']);
            $context = array_intersect_key($context, $_parent);
            $context += $_parent;
            // line 137
            yield "      </div>

      <div class=\"mt-8\">
        <div class=\"text-[12px] uppercase tracking-wide text-neutral-500 mb-4 font-semibold\">Duration</div>
        <div class=\"flex gap-3 flex-wrap\">
          ";
            // line 142
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["durations"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["d"]) {
                // line 143
                yield "            <button
              type=\"button\"
              x-show=\"durationAvailable(\x27";
                // line 145
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $context["d"], "html", null, true);
                yield "\x27)\"
              x-on:click=\"pickDuration(\x27";
                // line 146
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $context["d"], "html", null, true);
                yield "\x27)\"
              x-bind:class=\"selectedDuration === \x27";
                // line 147
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $context["d"], "html", null, true);
                yield "\x27 ? \x27bg-[#9F5434] border-[#9F5434] text-white font-semibold\x27 : \x27bg-white border-neutral-200 text-neutral-700 hover:border-neutral-400\x27\"
              class=\"px-5 py-2.5 rounded-xl border text-[13px] transition-all\"
            >
              ";
                // line 150
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $context["d"], "html", null, true);
                yield "
            </button>
          ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['d'], $context['_parent']);
            $context = array_intersect_key($context, $_parent);
            $context += $_parent;
            // line 153
            yield "        </div>
      </div>

      <div x-show=\"selectedTime\" x-cloak class=\"mt-6 p-5 bg-[#9F5434]/5 border border-[#9F5434]/20 rounded-2xl flex items-center gap-3\">
        ";
            // line 157
            yield from $this->load("cfc_media_hub:icon", 157)->unwrap()->yield(CoreExtension::toArray(["name" => "clock", "size" => "w-4 h-4 text-[#9F5434]"]));
            // line 158
            yield "        <span class=\"text-[14px] text-neutral-700\">
          <strong x-text=\"selectedTime + \x27 - \x27 + endTime(selectedTime, selectedDuration)\"></strong> &middot; <span x-text=\"selectedDuration\"></span>
        </span>
      </div>
    </div>
  ";
        }
        // line 164
        yield "</div>
";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["matrix", "durations_json", "duration_hours_json", "default_duration", "date_field_id", "time_field_id", "duration_field_id", "has_space", "days", "time_slots", "phantom_slots", "durations"]);        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "cfc_media_hub:booking-datetime-picker";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  360 => 164,  352 => 158,  350 => 157,  344 => 153,  334 => 150,  328 => 147,  324 => 146,  320 => 145,  316 => 143,  312 => 142,  305 => 137,  295 => 134,  289 => 130,  284 => 129,  274 => 126,  265 => 122,  261 => 121,  257 => 120,  252 => 118,  248 => 117,  244 => 115,  240 => 114,  228 => 104,  217 => 100,  213 => 99,  205 => 96,  199 => 95,  193 => 94,  184 => 90,  180 => 89,  176 => 88,  171 => 86,  167 => 85,  163 => 83,  159 => 82,  155 => 80,  149 => 76,  147 => 75,  139 => 70,  129 => 63,  121 => 58,  113 => 53,  66 => 9,  58 => 4,  54 => 3,  50 => 2,  44 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "cfc_media_hub:booking-datetime-picker", "themes/custom/cfc_media_hub/components/booking-datetime-picker/booking-datetime-picker.twig");
    }
    
    public function ensureSecurityChecked(): void
    {
        if ($this->sandbox->isSandboxed($this->source)) {
            $this->checkSecurity();
        }
    }
    
    public function checkSecurity()
    {
        static $tags = ["if" => 75, "for" => 82, "include" => 157];
        static $filters = ["raw" => 2, "escape" => 9];
        static $functions = [];
        static $tests = [];

        try {
            $this->sandbox->checkSecurity(
                [0 => "if", 1 => "for", 2 => "include"],
                [0 => "raw", 1 => "escape"],
                [],
                [],
                $this->source
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            } elseif ($e instanceof SecurityNotAllowedTestError && isset($tests[$e->getTestName()])) {
                $e->setTemplateLine($tests[$e->getTestName()]);
            }

            throw $e;
        }

    }
}
